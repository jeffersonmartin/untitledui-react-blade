---
name: inertia-page
description: Build or refactor a Laravel Inertia + React page following clean separation patterns
argument-hint: [PageName or file path]
---

# Build / Refactor an Inertia React Page

You are helping build or refactor a Laravel Inertia + React page for **$ARGUMENTS**.

Follow these rules strictly. They exist to keep page components small, readable, and maintainable.

---

## The Three Layers

Every Inertia page has three layers. Never mix them.

### 1. Laravel Controller (data in, data out)

The controller is responsible for:
- Querying the database
- Authorization checks
- Validation
- Passing data to the page via `Inertia::render()`

```php
// app/Http/Controllers/UsersController.php
public function index(Request $request)
{
    return Inertia::render('Users/Index', [
        'users' => User::query()
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->paginate(20),
        'filters' => $request->only(['search', 'status']),
    ]);
}
```

Rules:
- All database queries happen here, never in React
- Shape the data for the view — don't make React do heavy transformations
- Use `only` or `except` on Inertia responses for partial reloads when possible

### 2. Custom Hooks (client-side behavior)

Custom hooks handle anything interactive that happens in the browser:
- Inertia router calls (`router.get`, `router.post`, `router.delete`)
- Form state via `useForm()`
- UI state that multiple components need (modals, filters, selection)
- Debounced search, optimistic updates, etc.

Place hooks in a `hooks/` directory, named `use-<thing>.ts`.

```tsx
// hooks/use-user-filters.ts
import { router } from '@inertiajs/react';
import { useState } from 'react';

export function useUserFilters(initialFilters: { search?: string; status?: string }) {
    const [filters, setFilters] = useState(initialFilters);

    const updateFilters = (newFilters: Partial<typeof filters>) => {
        const merged = { ...filters, ...newFilters };
        setFilters(merged);
        router.get('/users', merged, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const resetFilters = () => {
        setFilters({});
        router.get('/users');
    };

    return { filters, updateFilters, resetFilters };
}
```

Rules:
- One hook per concern (filtering, CRUD actions, modal state — separate hooks)
- Hooks return plain data and functions, never JSX
- Name the file `use-<noun>.ts` or `use-<noun>-<verb>.ts`
- Keep hooks under 60 lines. If longer, split into smaller hooks.

### 3. Page Component (wiring only)

The page component receives Inertia props and connects them to UI components via hooks. It should be **short and scannable**.

```tsx
// Pages/Users/Index.tsx
import { Head } from '@inertiajs/react';
import { useUserFilters } from '@/hooks/use-user-filters';
import { useUserActions } from '@/hooks/use-user-actions';

interface Props {
    users: PaginatedData<User>;
    filters: { search?: string; status?: string };
}

export default function UsersIndex({ users, filters }: Props) {
    const { filters: currentFilters, updateFilters, resetFilters } = useUserFilters(filters);
    const { deleteUser, restoreUser } = useUserActions();

    return (
        <>
            <Head title="Users" />
            <PageHeader title="Users" action={<CreateUserButton />} />
            <UserFilters
                filters={currentFilters}
                onChange={updateFilters}
                onReset={resetFilters}
            />
            <UserTable
                users={users.data}
                onDelete={deleteUser}
                onRestore={restoreUser}
            />
            <Pagination links={users.links} />
        </>
    );
}
```

Rules:
- **Target: under 50 lines.** If it's longer, extract something.
- No `useEffect` in page components. If you need one, it belongs in a hook.
- No `fetch` or `axios` calls. Use Inertia's `router` (via a hook) or the controller.
- No complex conditionals. If you have nested ternaries, extract a sub-component.
- Props interface at the top — this documents what the controller sends.

---

## Forms (use Inertia's useForm)

Always use Inertia's `useForm` for form state. Never write manual `useState` per field.

```tsx
// hooks/use-create-user-form.ts
import { useForm } from '@inertiajs/react';

export function useCreateUserForm() {
    const form = useForm({
        name: '',
        email: '',
        role: 'member',
    });

    const submit = () => {
        form.post('/users', {
            onSuccess: () => form.reset(),
        });
    };

    return { form, submit };
}
```

In the page or component:
```tsx
const { form, submit } = useCreateUserForm();

<Input
    label="Name"
    value={form.data.name}
    onChange={e => form.setData('name', e.target.value)}
    isInvalid={!!form.errors.name}
    hint={form.errors.name}
/>

<Button onClick={submit} isLoading={form.processing}>
    Create User
</Button>
```

Rules:
- `useForm` gives you `data`, `setData`, `errors`, `processing`, `reset` for free
- Never duplicate this with `useState` + manual error tracking
- Wrap `useForm` in a custom hook when the form has submit logic, callbacks, or transformations

---

## Inertia Partial Reloads

When only part of the page data needs refreshing (e.g., after a filter change), use partial reloads:

```tsx
router.get('/users', filters, {
    preserveState: true,   // keep component state (open modals, scroll position)
    preserveScroll: true,  // don't scroll to top
    only: ['users'],       // only refresh the 'users' prop from the controller
});
```

In the controller, mark expensive props as lazy:
```php
return Inertia::render('Users/Index', [
    'users' => fn () => User::paginate(20),       // always loaded
    'stats' => Inertia::lazy(fn () => Stats::get()), // only loaded when requested
]);
```

---

## File Organization

```
resources/js/
├── Pages/
│   └── Users/
│       ├── Index.tsx          # Page component (thin)
│       ├── Create.tsx
│       ├── Edit.tsx
│       └── components/        # Page-specific sub-components (optional)
│           ├── user-table.tsx
│           └── user-filters.tsx
├── hooks/
│   ├── use-user-filters.ts    # Shared or page-specific hooks
│   ├── use-user-actions.ts
│   └── use-create-user-form.ts
├── components/                # Shared UI components (UntitledUI, etc.)
├── types/                     # TypeScript interfaces
│   └── models.d.ts            # User, PaginatedData<T>, etc.
└── layouts/
    └── app-layout.tsx
```

Rules:
- Page-specific components go in `Pages/<Resource>/components/`
- Hooks that serve one page can live next to the page or in `hooks/`
- Shared hooks (used by 2+ pages) go in `hooks/`
- All files use **kebab-case** naming

---

## Type Definitions

Define shared types for your Eloquent models and Inertia pagination:

```tsx
// types/models.d.ts
interface User {
    id: number;
    name: string;
    email: string;
    role: 'admin' | 'member' | 'viewer';
    created_at: string;
}

interface PaginatedData<T> {
    data: T[];
    links: PaginationLink[];
    meta: {
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}
```

---

## Refactoring Checklist

When refactoring an existing page, follow this order:

1. **Identify the Inertia props** — what does the controller send? Write the `interface Props`.
2. **Extract data/fetch logic** — any `useEffect` + `fetch` should move to the Laravel controller.
3. **Extract interactions to hooks** — `router.get/post/delete`, `useForm`, filter state, modal open/close.
4. **Extract sub-components** — if the JSX has logical sections (header, filters, table, form), each becomes a component receiving props.
5. **Verify the page component** — it should now be under 50 lines, just wiring props to components via hooks.

---

## What NOT to Do

- **Don't fetch data in React.** If you're writing `useEffect(() => fetch(...))`, move that query to the Laravel controller and pass it as an Inertia prop.
- **Don't put business logic in React.** Authorization, complex calculations, data aggregation — all server-side.
- **Don't use `useState` for form fields.** Use `useForm` from `@inertiajs/react`.
- **Don't inline complex logic in JSX.** Extract to a hook or sub-component.
- **Don't pass more than ~5 props to a sub-component.** If you need more, group them into an object or rethink the component boundary.

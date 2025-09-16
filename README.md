# Actievadis

## Code Conventions

- Write comments only where the code is unclear or needs explanation.
- Backend code must always be written in English.
- Frontend code (user-facing) may remain in Dutch.

- ### For variable naming we use snake case like:
```
$this_is_my_variable
```

- ### Functions are done in camelCase like:
```
function myFunction
```

- Id should always be a UUID

## Branch Naming

Branch names should follow this pattern:

```
feature/{ISSUE_NUMBER}-{feature-name}
```

- Use lowercase letters and hyphens for feature names.
- Example: `feature/123-login-functionality`

## Database Rules

- Name all tables using plural nouns.
- Example: `users`, `orders`, `products`
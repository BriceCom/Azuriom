# TypeScript solide : types avancés, generics, inference

## 1. Generics

Les generics permettent de garder le type exact au lieu de perdre l'information avec `any`.

```ts
function identity<T>(value: T): T {
  return value;
}

const a = identity("hello"); // string
const b = identity(42);      // number
```

## 2. Contraintes de generics

Un generic peut etre limite avec `extends`.

```ts
function getId<T extends { id: string }>(item: T): string {
  return item.id;
}

getId({ id: "u1", name: "Alice" });
```

## 3. keyof

`keyof` extrait les cles d'un type.

```ts
type User = {
  id: string;
  email: string;
  age: number;
};

type UserKey = keyof User;
// "id" | "email" | "age"
```

## 4. Acces type-safe aux proprietes

```ts
function getValue<T, K extends keyof T>(obj: T, key: K): T[K] {
  return obj[key];
}

const user = {
  id: "u1",
  email: "a@example.com",
  age: 30
};

const email = getValue(user, "email"); // string
const age = getValue(user, "age");     // number
```

## 5. Types conditionnels

```ts
type IsString<T> = T extends string ? true : false;

type A = IsString<string>; // true
type B = IsString<number>; // false
```

## 6. infer

`infer` permet d'extraire un type depuis une structure.

```ts
type Return<T> = T extends (...args: any[]) => infer R ? R : never;

function createUser() {
  return { id: "u1", name: "Alice" };
}

type CreatedUser = Return<typeof createUser>;
// { id: string; name: string }
```

## 7. Mapped types

Transformer toutes les proprietes d'un type.

```ts
type ReadonlyUser<T> = {
  readonly [K in keyof T]: T[K];
};

type User = {
  id: string;
  name: string;
};

type LockedUser = ReadonlyUser<User>;
```

## 8. Partial, Required, Pick, Omit

```ts
type User = {
  id: string;
  email: string;
  password: string;
};

type UserPatch = Partial<User>;

type PublicUser = Omit<User, "password">;

type LoginPayload = Pick<User, "email" | "password">;

type CompleteUser = Required<User>;
```

## 9. Unions discriminantes

Tres utile pour les states, events, responses API.

```ts
type ApiResult<T> =
  | { status: "success"; data: T }
  | { status: "error"; error: string };

function handleResult<T>(result: ApiResult<T>) {
  if (result.status === "success") {
    return result.data;
  }

  return result.error;
}
```

## 10. Exhaustiveness checking

Force TypeScript a signaler les cas oublies.

```ts
type Role = "admin" | "user" | "guest";

function getPermissions(role: Role) {
  switch (role) {
    case "admin":
      return ["read", "write", "delete"];
    case "user":
      return ["read", "write"];
    case "guest":
      return ["read"];
    default: {
      const neverRole: never = role;
      return neverRole;
    }
  }
}
```

## 11. Template literal types

```ts
type Method = "GET" | "POST";
type Route = "/users" | "/posts";

type Endpoint = `${Method} ${Route}`;
// "GET /users" | "GET /posts" | "POST /users" | "POST /posts"
```

## 12. Types pour API

```ts
type ApiResponse<T> = {
  data: T;
  meta: {
    page: number;
    total: number;
  };
};

type User = {
  id: string;
  email: string;
};

type UserResponse = ApiResponse<User>;
type UsersResponse = ApiResponse<User[]>;
```

## 13. Inference avec as const

Sans `as const`, TypeScript elargit les types.

```ts
const roles = ["admin", "user", "guest"] as const;

type Role = typeof roles[number];
// "admin" | "user" | "guest"
```

## 14. satisfies

`satisfies` verifie une forme sans perdre l'inference precise.

```ts
type RouteConfig = {
  method: "GET" | "POST";
  path: string;
};

const route = {
  method: "GET",
  path: "/users"
} satisfies RouteConfig;

route.method;
// "GET", pas seulement "GET" | "POST"
```

## 15. Exemple solide : router type-safe

```ts
type RouteMap = {
  "GET /users": {
    params: never;
    response: { id: string; email: string }[];
  };
  "GET /users/:id": {
    params: { id: string };
    response: { id: string; email: string };
  };
  "POST /users": {
    params: never;
    body: { email: string; password: string };
    response: { id: string; email: string };
  };
};

type RouteKey = keyof RouteMap;

type ParamsOf<R extends RouteKey> = RouteMap[R] extends { params: infer P }
  ? P
  : never;

type BodyOf<R extends RouteKey> = RouteMap[R] extends { body: infer B }
  ? B
  : never;

type ResponseOf<R extends RouteKey> = RouteMap[R]["response"];

async function request<R extends RouteKey>(
  route: R,
  options: {
    params?: ParamsOf<R>;
    body?: BodyOf<R>;
  }
): Promise<ResponseOf<R>> {
  throw new Error("not implemented");
}

const users = await request("GET /users", {});
// { id: string; email: string }[]

const user = await request("GET /users/:id", {
  params: { id: "u1" }
});
// { id: string; email: string }
```

## 16. Regles de base

* eviter `any`
* preferer `unknown` si le type est inconnu
* utiliser les unions discriminantes pour les states
* utiliser `keyof`, `T[K]`, `infer`, `as const`, `satisfies`
* typer les frontieres : API, DB, config, env
* laisser TypeScript inferer quand il sait deja
* typer explicitement quand une fonction publique expose un contrat

## 17. Anti-patterns

```ts
// Mauvais
function parse(data: any) {
  return data.user.email;
}
```

```ts
// Meilleur
function parse(data: unknown) {
  if (
    typeof data === "object" &&
    data !== null &&
    "user" in data
  ) {
    return data;
  }

  throw new Error("invalid data");
}
```

## 18. Checklist

* Generics utilises pour conserver le type exact
* Pas de `any` inutile
* Types derives au lieu de types dupliques
* `as const` pour les constantes metier
* `satisfies` pour les objets de config
* `never` pour verifier les cas impossibles
* Types API separes des types internes
* Runtime validation pour les donnees externes

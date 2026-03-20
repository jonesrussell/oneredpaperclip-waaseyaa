import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::bulkDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:193
* @route '/dashboard/users/bulk-delete'
*/
export const bulkDelete = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

bulkDelete.definition = {
    methods: ["post"],
    url: '/dashboard/users/bulk-delete',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::bulkDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:193
* @route '/dashboard/users/bulk-delete'
*/
bulkDelete.url = (options?: RouteQueryOptions) => {
    return bulkDelete.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::bulkDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:193
* @route '/dashboard/users/bulk-delete'
*/
bulkDelete.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::bulkDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:193
* @route '/dashboard/users/bulk-delete'
*/
const bulkDeleteForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkDelete.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::bulkDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:193
* @route '/dashboard/users/bulk-delete'
*/
bulkDeleteForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkDelete.url(options),
    method: 'post',
})

bulkDelete.form = bulkDeleteForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::bulkToggleAdmin
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:219
* @route '/dashboard/users/bulk-toggle-admin'
*/
export const bulkToggleAdmin = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkToggleAdmin.url(options),
    method: 'post',
})

bulkToggleAdmin.definition = {
    methods: ["post"],
    url: '/dashboard/users/bulk-toggle-admin',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::bulkToggleAdmin
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:219
* @route '/dashboard/users/bulk-toggle-admin'
*/
bulkToggleAdmin.url = (options?: RouteQueryOptions) => {
    return bulkToggleAdmin.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::bulkToggleAdmin
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:219
* @route '/dashboard/users/bulk-toggle-admin'
*/
bulkToggleAdmin.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkToggleAdmin.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::bulkToggleAdmin
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:219
* @route '/dashboard/users/bulk-toggle-admin'
*/
const bulkToggleAdminForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkToggleAdmin.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::bulkToggleAdmin
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:219
* @route '/dashboard/users/bulk-toggle-admin'
*/
bulkToggleAdminForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkToggleAdmin.url(options),
    method: 'post',
})

bulkToggleAdmin.form = bulkToggleAdminForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::toggleAdmin
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:172
* @route '/dashboard/users/{user}/toggle-admin'
*/
export const toggleAdmin = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleAdmin.url(args, options),
    method: 'post',
})

toggleAdmin.definition = {
    methods: ["post"],
    url: '/dashboard/users/{user}/toggle-admin',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::toggleAdmin
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:172
* @route '/dashboard/users/{user}/toggle-admin'
*/
toggleAdmin.url = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    if (Array.isArray(args)) {
        args = {
            user: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: args.user,
    }

    return toggleAdmin.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::toggleAdmin
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:172
* @route '/dashboard/users/{user}/toggle-admin'
*/
toggleAdmin.post = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleAdmin.url(args, options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::toggleAdmin
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:172
* @route '/dashboard/users/{user}/toggle-admin'
*/
const toggleAdminForm = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleAdmin.url(args, options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::toggleAdmin
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:172
* @route '/dashboard/users/{user}/toggle-admin'
*/
toggleAdminForm.post = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleAdmin.url(args, options),
    method: 'post',
})

toggleAdmin.form = toggleAdminForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:31
* @route '/dashboard/users'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/dashboard/users',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:31
* @route '/dashboard/users'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:31
* @route '/dashboard/users'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:31
* @route '/dashboard/users'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:31
* @route '/dashboard/users'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:31
* @route '/dashboard/users'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:31
* @route '/dashboard/users'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:68
* @route '/dashboard/users/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/dashboard/users/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:68
* @route '/dashboard/users/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:68
* @route '/dashboard/users/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:68
* @route '/dashboard/users/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:68
* @route '/dashboard/users/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:68
* @route '/dashboard/users/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:68
* @route '/dashboard/users/create'
*/
createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::store
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:77
* @route '/dashboard/users'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/dashboard/users',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::store
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:77
* @route '/dashboard/users'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::store
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:77
* @route '/dashboard/users'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::store
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:77
* @route '/dashboard/users'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::store
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:77
* @route '/dashboard/users'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:93
* @route '/dashboard/users/{user}'
*/
export const show = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/dashboard/users/{user}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:93
* @route '/dashboard/users/{user}'
*/
show.url = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    if (Array.isArray(args)) {
        args = {
            user: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: args.user,
    }

    return show.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:93
* @route '/dashboard/users/{user}'
*/
show.get = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:93
* @route '/dashboard/users/{user}'
*/
show.head = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:93
* @route '/dashboard/users/{user}'
*/
const showForm = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:93
* @route '/dashboard/users/{user}'
*/
showForm.get = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:93
* @route '/dashboard/users/{user}'
*/
showForm.head = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:107
* @route '/dashboard/users/{user}/edit'
*/
export const edit = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/dashboard/users/{user}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:107
* @route '/dashboard/users/{user}/edit'
*/
edit.url = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    if (Array.isArray(args)) {
        args = {
            user: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: args.user,
    }

    return edit.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:107
* @route '/dashboard/users/{user}/edit'
*/
edit.get = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:107
* @route '/dashboard/users/{user}/edit'
*/
edit.head = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:107
* @route '/dashboard/users/{user}/edit'
*/
const editForm = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:107
* @route '/dashboard/users/{user}/edit'
*/
editForm.get = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:107
* @route '/dashboard/users/{user}/edit'
*/
editForm.head = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:122
* @route '/dashboard/users/{user}'
*/
export const update = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/dashboard/users/{user}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:122
* @route '/dashboard/users/{user}'
*/
update.url = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    if (Array.isArray(args)) {
        args = {
            user: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: args.user,
    }

    return update.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:122
* @route '/dashboard/users/{user}'
*/
update.put = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:122
* @route '/dashboard/users/{user}'
*/
update.patch = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:122
* @route '/dashboard/users/{user}'
*/
const updateForm = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:122
* @route '/dashboard/users/{user}'
*/
updateForm.put = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:122
* @route '/dashboard/users/{user}'
*/
updateForm.patch = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::destroy
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:154
* @route '/dashboard/users/{user}'
*/
export const destroy = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/dashboard/users/{user}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::destroy
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:154
* @route '/dashboard/users/{user}'
*/
destroy.url = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    if (Array.isArray(args)) {
        args = {
            user: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: args.user,
    }

    return destroy.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::destroy
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:154
* @route '/dashboard/users/{user}'
*/
destroy.delete = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::destroy
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:154
* @route '/dashboard/users/{user}'
*/
const destroyForm = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\UserController::destroy
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/UserController.php:154
* @route '/dashboard/users/{user}'
*/
destroyForm.delete = (args: { user: string | number } | [user: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const UserController = { bulkDelete, bulkToggleAdmin, toggleAdmin, index, create, store, show, edit, update, destroy }

export default UserController
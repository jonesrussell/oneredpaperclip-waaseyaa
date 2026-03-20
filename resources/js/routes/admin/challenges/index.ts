import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::index
* @see app/Http/Controllers/Dashboard/ChallengeController.php:16
* @route '/dashboard/admin/challenges'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/dashboard/admin/challenges',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::index
* @see app/Http/Controllers/Dashboard/ChallengeController.php:16
* @route '/dashboard/admin/challenges'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::index
* @see app/Http/Controllers/Dashboard/ChallengeController.php:16
* @route '/dashboard/admin/challenges'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::index
* @see app/Http/Controllers/Dashboard/ChallengeController.php:16
* @route '/dashboard/admin/challenges'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::index
* @see app/Http/Controllers/Dashboard/ChallengeController.php:16
* @route '/dashboard/admin/challenges'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::index
* @see app/Http/Controllers/Dashboard/ChallengeController.php:16
* @route '/dashboard/admin/challenges'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::index
* @see app/Http/Controllers/Dashboard/ChallengeController.php:16
* @route '/dashboard/admin/challenges'
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
* @see \App\Http\Controllers\Dashboard\ChallengeController::trashed
* @see app/Http/Controllers/Dashboard/ChallengeController.php:64
* @route '/dashboard/admin/challenges/trashed'
*/
export const trashed = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: trashed.url(options),
    method: 'get',
})

trashed.definition = {
    methods: ["get","head"],
    url: '/dashboard/admin/challenges/trashed',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::trashed
* @see app/Http/Controllers/Dashboard/ChallengeController.php:64
* @route '/dashboard/admin/challenges/trashed'
*/
trashed.url = (options?: RouteQueryOptions) => {
    return trashed.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::trashed
* @see app/Http/Controllers/Dashboard/ChallengeController.php:64
* @route '/dashboard/admin/challenges/trashed'
*/
trashed.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: trashed.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::trashed
* @see app/Http/Controllers/Dashboard/ChallengeController.php:64
* @route '/dashboard/admin/challenges/trashed'
*/
trashed.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: trashed.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::trashed
* @see app/Http/Controllers/Dashboard/ChallengeController.php:64
* @route '/dashboard/admin/challenges/trashed'
*/
const trashedForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: trashed.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::trashed
* @see app/Http/Controllers/Dashboard/ChallengeController.php:64
* @route '/dashboard/admin/challenges/trashed'
*/
trashedForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: trashed.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::trashed
* @see app/Http/Controllers/Dashboard/ChallengeController.php:64
* @route '/dashboard/admin/challenges/trashed'
*/
trashedForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: trashed.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

trashed.form = trashedForm

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::show
* @see app/Http/Controllers/Dashboard/ChallengeController.php:54
* @route '/dashboard/admin/challenges/{challenge}'
*/
export const show = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/dashboard/admin/challenges/{challenge}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::show
* @see app/Http/Controllers/Dashboard/ChallengeController.php:54
* @route '/dashboard/admin/challenges/{challenge}'
*/
show.url = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { challenge: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { challenge: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            challenge: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        challenge: typeof args.challenge === 'object'
        ? args.challenge.slug
        : args.challenge,
    }

    return show.definition.url
            .replace('{challenge}', parsedArgs.challenge.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::show
* @see app/Http/Controllers/Dashboard/ChallengeController.php:54
* @route '/dashboard/admin/challenges/{challenge}'
*/
show.get = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::show
* @see app/Http/Controllers/Dashboard/ChallengeController.php:54
* @route '/dashboard/admin/challenges/{challenge}'
*/
show.head = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::show
* @see app/Http/Controllers/Dashboard/ChallengeController.php:54
* @route '/dashboard/admin/challenges/{challenge}'
*/
const showForm = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::show
* @see app/Http/Controllers/Dashboard/ChallengeController.php:54
* @route '/dashboard/admin/challenges/{challenge}'
*/
showForm.get = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::show
* @see app/Http/Controllers/Dashboard/ChallengeController.php:54
* @route '/dashboard/admin/challenges/{challenge}'
*/
showForm.head = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Dashboard\ChallengeController::unpublish
* @see app/Http/Controllers/Dashboard/ChallengeController.php:77
* @route '/dashboard/admin/challenges/{challenge}/unpublish'
*/
export const unpublish = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: unpublish.url(args, options),
    method: 'post',
})

unpublish.definition = {
    methods: ["post"],
    url: '/dashboard/admin/challenges/{challenge}/unpublish',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::unpublish
* @see app/Http/Controllers/Dashboard/ChallengeController.php:77
* @route '/dashboard/admin/challenges/{challenge}/unpublish'
*/
unpublish.url = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { challenge: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { challenge: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            challenge: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        challenge: typeof args.challenge === 'object'
        ? args.challenge.slug
        : args.challenge,
    }

    return unpublish.definition.url
            .replace('{challenge}', parsedArgs.challenge.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::unpublish
* @see app/Http/Controllers/Dashboard/ChallengeController.php:77
* @route '/dashboard/admin/challenges/{challenge}/unpublish'
*/
unpublish.post = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: unpublish.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::unpublish
* @see app/Http/Controllers/Dashboard/ChallengeController.php:77
* @route '/dashboard/admin/challenges/{challenge}/unpublish'
*/
const unpublishForm = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: unpublish.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::unpublish
* @see app/Http/Controllers/Dashboard/ChallengeController.php:77
* @route '/dashboard/admin/challenges/{challenge}/unpublish'
*/
unpublishForm.post = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: unpublish.url(args, options),
    method: 'post',
})

unpublish.form = unpublishForm

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkUnpublish
* @see app/Http/Controllers/Dashboard/ChallengeController.php:84
* @route '/dashboard/admin/challenges/bulk-unpublish'
*/
export const bulkUnpublish = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkUnpublish.url(options),
    method: 'post',
})

bulkUnpublish.definition = {
    methods: ["post"],
    url: '/dashboard/admin/challenges/bulk-unpublish',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkUnpublish
* @see app/Http/Controllers/Dashboard/ChallengeController.php:84
* @route '/dashboard/admin/challenges/bulk-unpublish'
*/
bulkUnpublish.url = (options?: RouteQueryOptions) => {
    return bulkUnpublish.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkUnpublish
* @see app/Http/Controllers/Dashboard/ChallengeController.php:84
* @route '/dashboard/admin/challenges/bulk-unpublish'
*/
bulkUnpublish.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkUnpublish.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkUnpublish
* @see app/Http/Controllers/Dashboard/ChallengeController.php:84
* @route '/dashboard/admin/challenges/bulk-unpublish'
*/
const bulkUnpublishForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkUnpublish.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkUnpublish
* @see app/Http/Controllers/Dashboard/ChallengeController.php:84
* @route '/dashboard/admin/challenges/bulk-unpublish'
*/
bulkUnpublishForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkUnpublish.url(options),
    method: 'post',
})

bulkUnpublish.form = bulkUnpublishForm

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::destroy
* @see app/Http/Controllers/Dashboard/ChallengeController.php:93
* @route '/dashboard/admin/challenges/{challenge}'
*/
export const destroy = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/dashboard/admin/challenges/{challenge}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::destroy
* @see app/Http/Controllers/Dashboard/ChallengeController.php:93
* @route '/dashboard/admin/challenges/{challenge}'
*/
destroy.url = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { challenge: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { challenge: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            challenge: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        challenge: typeof args.challenge === 'object'
        ? args.challenge.slug
        : args.challenge,
    }

    return destroy.definition.url
            .replace('{challenge}', parsedArgs.challenge.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::destroy
* @see app/Http/Controllers/Dashboard/ChallengeController.php:93
* @route '/dashboard/admin/challenges/{challenge}'
*/
destroy.delete = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::destroy
* @see app/Http/Controllers/Dashboard/ChallengeController.php:93
* @route '/dashboard/admin/challenges/{challenge}'
*/
const destroyForm = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::destroy
* @see app/Http/Controllers/Dashboard/ChallengeController.php:93
* @route '/dashboard/admin/challenges/{challenge}'
*/
destroyForm.delete = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:100
* @route '/dashboard/admin/challenges/bulk-delete'
*/
export const bulkDelete = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

bulkDelete.definition = {
    methods: ["post"],
    url: '/dashboard/admin/challenges/bulk-delete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:100
* @route '/dashboard/admin/challenges/bulk-delete'
*/
bulkDelete.url = (options?: RouteQueryOptions) => {
    return bulkDelete.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:100
* @route '/dashboard/admin/challenges/bulk-delete'
*/
bulkDelete.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:100
* @route '/dashboard/admin/challenges/bulk-delete'
*/
const bulkDeleteForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkDelete.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:100
* @route '/dashboard/admin/challenges/bulk-delete'
*/
bulkDeleteForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkDelete.url(options),
    method: 'post',
})

bulkDelete.form = bulkDeleteForm

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::restore
* @see app/Http/Controllers/Dashboard/ChallengeController.php:109
* @route '/dashboard/admin/challenges/{challenge}/restore'
*/
export const restore = (args: { challenge: string | number } | [challenge: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: restore.url(args, options),
    method: 'post',
})

restore.definition = {
    methods: ["post"],
    url: '/dashboard/admin/challenges/{challenge}/restore',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::restore
* @see app/Http/Controllers/Dashboard/ChallengeController.php:109
* @route '/dashboard/admin/challenges/{challenge}/restore'
*/
restore.url = (args: { challenge: string | number } | [challenge: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { challenge: args }
    }

    if (Array.isArray(args)) {
        args = {
            challenge: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        challenge: args.challenge,
    }

    return restore.definition.url
            .replace('{challenge}', parsedArgs.challenge.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::restore
* @see app/Http/Controllers/Dashboard/ChallengeController.php:109
* @route '/dashboard/admin/challenges/{challenge}/restore'
*/
restore.post = (args: { challenge: string | number } | [challenge: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: restore.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::restore
* @see app/Http/Controllers/Dashboard/ChallengeController.php:109
* @route '/dashboard/admin/challenges/{challenge}/restore'
*/
const restoreForm = (args: { challenge: string | number } | [challenge: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: restore.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::restore
* @see app/Http/Controllers/Dashboard/ChallengeController.php:109
* @route '/dashboard/admin/challenges/{challenge}/restore'
*/
restoreForm.post = (args: { challenge: string | number } | [challenge: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: restore.url(args, options),
    method: 'post',
})

restore.form = restoreForm

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkRestore
* @see app/Http/Controllers/Dashboard/ChallengeController.php:117
* @route '/dashboard/admin/challenges/bulk-restore'
*/
export const bulkRestore = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkRestore.url(options),
    method: 'post',
})

bulkRestore.definition = {
    methods: ["post"],
    url: '/dashboard/admin/challenges/bulk-restore',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkRestore
* @see app/Http/Controllers/Dashboard/ChallengeController.php:117
* @route '/dashboard/admin/challenges/bulk-restore'
*/
bulkRestore.url = (options?: RouteQueryOptions) => {
    return bulkRestore.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkRestore
* @see app/Http/Controllers/Dashboard/ChallengeController.php:117
* @route '/dashboard/admin/challenges/bulk-restore'
*/
bulkRestore.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkRestore.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkRestore
* @see app/Http/Controllers/Dashboard/ChallengeController.php:117
* @route '/dashboard/admin/challenges/bulk-restore'
*/
const bulkRestoreForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkRestore.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkRestore
* @see app/Http/Controllers/Dashboard/ChallengeController.php:117
* @route '/dashboard/admin/challenges/bulk-restore'
*/
bulkRestoreForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkRestore.url(options),
    method: 'post',
})

bulkRestore.form = bulkRestoreForm

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::forceDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:126
* @route '/dashboard/admin/challenges/{challenge}/force'
*/
export const forceDelete = (args: { challenge: string | number } | [challenge: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: forceDelete.url(args, options),
    method: 'delete',
})

forceDelete.definition = {
    methods: ["delete"],
    url: '/dashboard/admin/challenges/{challenge}/force',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::forceDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:126
* @route '/dashboard/admin/challenges/{challenge}/force'
*/
forceDelete.url = (args: { challenge: string | number } | [challenge: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { challenge: args }
    }

    if (Array.isArray(args)) {
        args = {
            challenge: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        challenge: args.challenge,
    }

    return forceDelete.definition.url
            .replace('{challenge}', parsedArgs.challenge.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::forceDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:126
* @route '/dashboard/admin/challenges/{challenge}/force'
*/
forceDelete.delete = (args: { challenge: string | number } | [challenge: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: forceDelete.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::forceDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:126
* @route '/dashboard/admin/challenges/{challenge}/force'
*/
const forceDeleteForm = (args: { challenge: string | number } | [challenge: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: forceDelete.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::forceDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:126
* @route '/dashboard/admin/challenges/{challenge}/force'
*/
forceDeleteForm.delete = (args: { challenge: string | number } | [challenge: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: forceDelete.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

forceDelete.form = forceDeleteForm

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkForceDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:134
* @route '/dashboard/admin/challenges/bulk-force-delete'
*/
export const bulkForceDelete = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkForceDelete.url(options),
    method: 'post',
})

bulkForceDelete.definition = {
    methods: ["post"],
    url: '/dashboard/admin/challenges/bulk-force-delete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkForceDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:134
* @route '/dashboard/admin/challenges/bulk-force-delete'
*/
bulkForceDelete.url = (options?: RouteQueryOptions) => {
    return bulkForceDelete.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkForceDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:134
* @route '/dashboard/admin/challenges/bulk-force-delete'
*/
bulkForceDelete.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkForceDelete.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkForceDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:134
* @route '/dashboard/admin/challenges/bulk-force-delete'
*/
const bulkForceDeleteForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkForceDelete.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dashboard\ChallengeController::bulkForceDelete
* @see app/Http/Controllers/Dashboard/ChallengeController.php:134
* @route '/dashboard/admin/challenges/bulk-force-delete'
*/
bulkForceDeleteForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkForceDelete.url(options),
    method: 'post',
})

bulkForceDelete.form = bulkForceDeleteForm

const challenges = {
    index: Object.assign(index, index),
    trashed: Object.assign(trashed, trashed),
    show: Object.assign(show, show),
    unpublish: Object.assign(unpublish, unpublish),
    bulkUnpublish: Object.assign(bulkUnpublish, bulkUnpublish),
    destroy: Object.assign(destroy, destroy),
    bulkDelete: Object.assign(bulkDelete, bulkDelete),
    restore: Object.assign(restore, restore),
    bulkRestore: Object.assign(bulkRestore, bulkRestore),
    forceDelete: Object.assign(forceDelete, forceDelete),
    bulkForceDelete: Object.assign(bulkForceDelete, bulkForceDelete),
}

export default challenges
import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::trashed
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:283
* @route '/dashboard/articles/trashed'
*/
export const trashed = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: trashed.url(options),
    method: 'get',
})

trashed.definition = {
    methods: ["get","head"],
    url: '/dashboard/articles/trashed',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::trashed
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:283
* @route '/dashboard/articles/trashed'
*/
trashed.url = (options?: RouteQueryOptions) => {
    return trashed.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::trashed
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:283
* @route '/dashboard/articles/trashed'
*/
trashed.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: trashed.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::trashed
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:283
* @route '/dashboard/articles/trashed'
*/
trashed.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: trashed.url(options),
    method: 'head',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::trashed
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:283
* @route '/dashboard/articles/trashed'
*/
const trashedForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: trashed.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::trashed
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:283
* @route '/dashboard/articles/trashed'
*/
trashedForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: trashed.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::trashed
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:283
* @route '/dashboard/articles/trashed'
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
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkRestore
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:321
* @route '/dashboard/articles/bulk-restore'
*/
export const bulkRestore = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkRestore.url(options),
    method: 'post',
})

bulkRestore.definition = {
    methods: ["post"],
    url: '/dashboard/articles/bulk-restore',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkRestore
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:321
* @route '/dashboard/articles/bulk-restore'
*/
bulkRestore.url = (options?: RouteQueryOptions) => {
    return bulkRestore.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkRestore
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:321
* @route '/dashboard/articles/bulk-restore'
*/
bulkRestore.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkRestore.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkRestore
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:321
* @route '/dashboard/articles/bulk-restore'
*/
const bulkRestoreForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkRestore.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkRestore
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:321
* @route '/dashboard/articles/bulk-restore'
*/
bulkRestoreForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkRestore.url(options),
    method: 'post',
})

bulkRestore.form = bulkRestoreForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkForceDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:349
* @route '/dashboard/articles/bulk-force-delete'
*/
export const bulkForceDelete = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkForceDelete.url(options),
    method: 'post',
})

bulkForceDelete.definition = {
    methods: ["post"],
    url: '/dashboard/articles/bulk-force-delete',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkForceDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:349
* @route '/dashboard/articles/bulk-force-delete'
*/
bulkForceDelete.url = (options?: RouteQueryOptions) => {
    return bulkForceDelete.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkForceDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:349
* @route '/dashboard/articles/bulk-force-delete'
*/
bulkForceDelete.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkForceDelete.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkForceDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:349
* @route '/dashboard/articles/bulk-force-delete'
*/
const bulkForceDeleteForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkForceDelete.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkForceDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:349
* @route '/dashboard/articles/bulk-force-delete'
*/
bulkForceDeleteForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkForceDelete.url(options),
    method: 'post',
})

bulkForceDelete.form = bulkForceDeleteForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::restore
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:311
* @route '/dashboard/articles/{id}/restore'
*/
export const restore = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: restore.url(args, options),
    method: 'post',
})

restore.definition = {
    methods: ["post"],
    url: '/dashboard/articles/{id}/restore',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::restore
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:311
* @route '/dashboard/articles/{id}/restore'
*/
restore.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return restore.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::restore
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:311
* @route '/dashboard/articles/{id}/restore'
*/
restore.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: restore.url(args, options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::restore
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:311
* @route '/dashboard/articles/{id}/restore'
*/
const restoreForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: restore.url(args, options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::restore
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:311
* @route '/dashboard/articles/{id}/restore'
*/
restoreForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: restore.url(args, options),
    method: 'post',
})

restore.form = restoreForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::forceDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:339
* @route '/dashboard/articles/{id}/force-delete'
*/
export const forceDelete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: forceDelete.url(args, options),
    method: 'delete',
})

forceDelete.definition = {
    methods: ["delete"],
    url: '/dashboard/articles/{id}/force-delete',
} satisfies RouteDefinition<["delete"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::forceDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:339
* @route '/dashboard/articles/{id}/force-delete'
*/
forceDelete.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return forceDelete.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::forceDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:339
* @route '/dashboard/articles/{id}/force-delete'
*/
forceDelete.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: forceDelete.url(args, options),
    method: 'delete',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::forceDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:339
* @route '/dashboard/articles/{id}/force-delete'
*/
const forceDeleteForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: forceDelete.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::forceDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:339
* @route '/dashboard/articles/{id}/force-delete'
*/
forceDeleteForm.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:163
* @route '/dashboard/articles/bulk-delete'
*/
export const bulkDelete = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

bulkDelete.definition = {
    methods: ["post"],
    url: '/dashboard/articles/bulk-delete',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:163
* @route '/dashboard/articles/bulk-delete'
*/
bulkDelete.url = (options?: RouteQueryOptions) => {
    return bulkDelete.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:163
* @route '/dashboard/articles/bulk-delete'
*/
bulkDelete.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:163
* @route '/dashboard/articles/bulk-delete'
*/
const bulkDeleteForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkDelete.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkDelete
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:163
* @route '/dashboard/articles/bulk-delete'
*/
bulkDeleteForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkDelete.url(options),
    method: 'post',
})

bulkDelete.form = bulkDeleteForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkPublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:182
* @route '/dashboard/articles/bulk-publish'
*/
export const bulkPublish = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkPublish.url(options),
    method: 'post',
})

bulkPublish.definition = {
    methods: ["post"],
    url: '/dashboard/articles/bulk-publish',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkPublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:182
* @route '/dashboard/articles/bulk-publish'
*/
bulkPublish.url = (options?: RouteQueryOptions) => {
    return bulkPublish.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkPublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:182
* @route '/dashboard/articles/bulk-publish'
*/
bulkPublish.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkPublish.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkPublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:182
* @route '/dashboard/articles/bulk-publish'
*/
const bulkPublishForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkPublish.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkPublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:182
* @route '/dashboard/articles/bulk-publish'
*/
bulkPublishForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkPublish.url(options),
    method: 'post',
})

bulkPublish.form = bulkPublishForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkUnpublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:201
* @route '/dashboard/articles/bulk-unpublish'
*/
export const bulkUnpublish = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkUnpublish.url(options),
    method: 'post',
})

bulkUnpublish.definition = {
    methods: ["post"],
    url: '/dashboard/articles/bulk-unpublish',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkUnpublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:201
* @route '/dashboard/articles/bulk-unpublish'
*/
bulkUnpublish.url = (options?: RouteQueryOptions) => {
    return bulkUnpublish.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkUnpublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:201
* @route '/dashboard/articles/bulk-unpublish'
*/
bulkUnpublish.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkUnpublish.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkUnpublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:201
* @route '/dashboard/articles/bulk-unpublish'
*/
const bulkUnpublishForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkUnpublish.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::bulkUnpublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:201
* @route '/dashboard/articles/bulk-unpublish'
*/
bulkUnpublishForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: bulkUnpublish.url(options),
    method: 'post',
})

bulkUnpublish.form = bulkUnpublishForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::togglePublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:220
* @route '/dashboard/articles/{article}/toggle-publish'
*/
export const togglePublish = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: togglePublish.url(args, options),
    method: 'post',
})

togglePublish.definition = {
    methods: ["post"],
    url: '/dashboard/articles/{article}/toggle-publish',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::togglePublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:220
* @route '/dashboard/articles/{article}/toggle-publish'
*/
togglePublish.url = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { article: args }
    }

    if (Array.isArray(args)) {
        args = {
            article: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        article: args.article,
    }

    return togglePublish.definition.url
            .replace('{article}', parsedArgs.article.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::togglePublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:220
* @route '/dashboard/articles/{article}/toggle-publish'
*/
togglePublish.post = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: togglePublish.url(args, options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::togglePublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:220
* @route '/dashboard/articles/{article}/toggle-publish'
*/
const togglePublishForm = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: togglePublish.url(args, options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::togglePublish
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:220
* @route '/dashboard/articles/{article}/toggle-publish'
*/
togglePublishForm.post = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: togglePublish.url(args, options),
    method: 'post',
})

togglePublish.form = togglePublishForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::searchAssociatable
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:239
* @route '/dashboard/articles/search-associatable'
*/
export const searchAssociatable = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: searchAssociatable.url(options),
    method: 'get',
})

searchAssociatable.definition = {
    methods: ["get","head"],
    url: '/dashboard/articles/search-associatable',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::searchAssociatable
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:239
* @route '/dashboard/articles/search-associatable'
*/
searchAssociatable.url = (options?: RouteQueryOptions) => {
    return searchAssociatable.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::searchAssociatable
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:239
* @route '/dashboard/articles/search-associatable'
*/
searchAssociatable.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: searchAssociatable.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::searchAssociatable
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:239
* @route '/dashboard/articles/search-associatable'
*/
searchAssociatable.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: searchAssociatable.url(options),
    method: 'head',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::searchAssociatable
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:239
* @route '/dashboard/articles/search-associatable'
*/
const searchAssociatableForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchAssociatable.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::searchAssociatable
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:239
* @route '/dashboard/articles/search-associatable'
*/
searchAssociatableForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchAssociatable.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::searchAssociatable
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:239
* @route '/dashboard/articles/search-associatable'
*/
searchAssociatableForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchAssociatable.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

searchAssociatable.form = searchAssociatableForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:31
* @route '/dashboard/articles'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/dashboard/articles',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:31
* @route '/dashboard/articles'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:31
* @route '/dashboard/articles'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:31
* @route '/dashboard/articles'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:31
* @route '/dashboard/articles'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:31
* @route '/dashboard/articles'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::index
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:31
* @route '/dashboard/articles'
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
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:67
* @route '/dashboard/articles/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/dashboard/articles/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:67
* @route '/dashboard/articles/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:67
* @route '/dashboard/articles/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:67
* @route '/dashboard/articles/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:67
* @route '/dashboard/articles/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:67
* @route '/dashboard/articles/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::create
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:67
* @route '/dashboard/articles/create'
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
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::store
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:78
* @route '/dashboard/articles'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/dashboard/articles',
} satisfies RouteDefinition<["post"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::store
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:78
* @route '/dashboard/articles'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::store
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:78
* @route '/dashboard/articles'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::store
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:78
* @route '/dashboard/articles'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::store
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:78
* @route '/dashboard/articles'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:96
* @route '/dashboard/articles/{article}'
*/
export const show = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/dashboard/articles/{article}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:96
* @route '/dashboard/articles/{article}'
*/
show.url = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { article: args }
    }

    if (Array.isArray(args)) {
        args = {
            article: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        article: args.article,
    }

    return show.definition.url
            .replace('{article}', parsedArgs.article.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:96
* @route '/dashboard/articles/{article}'
*/
show.get = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:96
* @route '/dashboard/articles/{article}'
*/
show.head = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:96
* @route '/dashboard/articles/{article}'
*/
const showForm = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:96
* @route '/dashboard/articles/{article}'
*/
showForm.get = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::show
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:96
* @route '/dashboard/articles/{article}'
*/
showForm.head = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:112
* @route '/dashboard/articles/{article}/edit'
*/
export const edit = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/dashboard/articles/{article}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:112
* @route '/dashboard/articles/{article}/edit'
*/
edit.url = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { article: args }
    }

    if (Array.isArray(args)) {
        args = {
            article: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        article: args.article,
    }

    return edit.definition.url
            .replace('{article}', parsedArgs.article.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:112
* @route '/dashboard/articles/{article}/edit'
*/
edit.get = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:112
* @route '/dashboard/articles/{article}/edit'
*/
edit.head = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:112
* @route '/dashboard/articles/{article}/edit'
*/
const editForm = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:112
* @route '/dashboard/articles/{article}/edit'
*/
editForm.get = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::edit
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:112
* @route '/dashboard/articles/{article}/edit'
*/
editForm.head = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:130
* @route '/dashboard/articles/{article}'
*/
export const update = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/dashboard/articles/{article}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:130
* @route '/dashboard/articles/{article}'
*/
update.url = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { article: args }
    }

    if (Array.isArray(args)) {
        args = {
            article: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        article: args.article,
    }

    return update.definition.url
            .replace('{article}', parsedArgs.article.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:130
* @route '/dashboard/articles/{article}'
*/
update.put = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:130
* @route '/dashboard/articles/{article}'
*/
update.patch = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:130
* @route '/dashboard/articles/{article}'
*/
const updateForm = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:130
* @route '/dashboard/articles/{article}'
*/
updateForm.put = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::update
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:130
* @route '/dashboard/articles/{article}'
*/
updateForm.patch = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::destroy
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:150
* @route '/dashboard/articles/{article}'
*/
export const destroy = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/dashboard/articles/{article}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::destroy
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:150
* @route '/dashboard/articles/{article}'
*/
destroy.url = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { article: args }
    }

    if (Array.isArray(args)) {
        args = {
            article: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        article: args.article,
    }

    return destroy.definition.url
            .replace('{article}', parsedArgs.article.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::destroy
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:150
* @route '/dashboard/articles/{article}'
*/
destroy.delete = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::destroy
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:150
* @route '/dashboard/articles/{article}'
*/
const destroyForm = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \JonesRussell\NorthCloud\Http\Controllers\Admin\ArticleController::destroy
* @see vendor/jonesrussell/northcloud-laravel/src/Http/Controllers/Admin/ArticleController.php:150
* @route '/dashboard/articles/{article}'
*/
destroyForm.delete = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

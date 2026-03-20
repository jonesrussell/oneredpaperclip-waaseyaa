import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
import offers from './offers'
/**
* @see \App\Http\Controllers\ChallengeController::index
* @see app/Http/Controllers/ChallengeController.php:31
* @route '/challenges'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/challenges',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ChallengeController::index
* @see app/Http/Controllers/ChallengeController.php:31
* @route '/challenges'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ChallengeController::index
* @see app/Http/Controllers/ChallengeController.php:31
* @route '/challenges'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::index
* @see app/Http/Controllers/ChallengeController.php:31
* @route '/challenges'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ChallengeController::index
* @see app/Http/Controllers/ChallengeController.php:31
* @route '/challenges'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::index
* @see app/Http/Controllers/ChallengeController.php:31
* @route '/challenges'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::index
* @see app/Http/Controllers/ChallengeController.php:31
* @route '/challenges'
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
* @see \App\Http\Controllers\ChallengeController::create
* @see app/Http/Controllers/ChallengeController.php:73
* @route '/challenges/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/challenges/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ChallengeController::create
* @see app/Http/Controllers/ChallengeController.php:73
* @route '/challenges/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ChallengeController::create
* @see app/Http/Controllers/ChallengeController.php:73
* @route '/challenges/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::create
* @see app/Http/Controllers/ChallengeController.php:73
* @route '/challenges/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ChallengeController::create
* @see app/Http/Controllers/ChallengeController.php:73
* @route '/challenges/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::create
* @see app/Http/Controllers/ChallengeController.php:73
* @route '/challenges/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::create
* @see app/Http/Controllers/ChallengeController.php:73
* @route '/challenges/create'
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
* @see \App\Http\Controllers\ChallengeController::aiSuggest
* @see app/Http/Controllers/ChallengeController.php:205
* @route '/challenges/ai-suggest'
*/
export const aiSuggest = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: aiSuggest.url(options),
    method: 'post',
})

aiSuggest.definition = {
    methods: ["post"],
    url: '/challenges/ai-suggest',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ChallengeController::aiSuggest
* @see app/Http/Controllers/ChallengeController.php:205
* @route '/challenges/ai-suggest'
*/
aiSuggest.url = (options?: RouteQueryOptions) => {
    return aiSuggest.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ChallengeController::aiSuggest
* @see app/Http/Controllers/ChallengeController.php:205
* @route '/challenges/ai-suggest'
*/
aiSuggest.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: aiSuggest.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ChallengeController::aiSuggest
* @see app/Http/Controllers/ChallengeController.php:205
* @route '/challenges/ai-suggest'
*/
const aiSuggestForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: aiSuggest.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ChallengeController::aiSuggest
* @see app/Http/Controllers/ChallengeController.php:205
* @route '/challenges/ai-suggest'
*/
aiSuggestForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: aiSuggest.url(options),
    method: 'post',
})

aiSuggest.form = aiSuggestForm

/**
* @see \App\Http\Controllers\ChallengeController::show
* @see app/Http/Controllers/ChallengeController.php:123
* @route '/challenges/{challenge}'
*/
export const show = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/challenges/{challenge}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ChallengeController::show
* @see app/Http/Controllers/ChallengeController.php:123
* @route '/challenges/{challenge}'
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
* @see \App\Http\Controllers\ChallengeController::show
* @see app/Http/Controllers/ChallengeController.php:123
* @route '/challenges/{challenge}'
*/
show.get = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::show
* @see app/Http/Controllers/ChallengeController.php:123
* @route '/challenges/{challenge}'
*/
show.head = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ChallengeController::show
* @see app/Http/Controllers/ChallengeController.php:123
* @route '/challenges/{challenge}'
*/
const showForm = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::show
* @see app/Http/Controllers/ChallengeController.php:123
* @route '/challenges/{challenge}'
*/
showForm.get = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::show
* @see app/Http/Controllers/ChallengeController.php:123
* @route '/challenges/{challenge}'
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
* @see \App\Http\Controllers\ChallengeController::edit
* @see app/Http/Controllers/ChallengeController.php:95
* @route '/challenges/{challenge}/edit'
*/
export const edit = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/challenges/{challenge}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ChallengeController::edit
* @see app/Http/Controllers/ChallengeController.php:95
* @route '/challenges/{challenge}/edit'
*/
edit.url = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return edit.definition.url
            .replace('{challenge}', parsedArgs.challenge.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ChallengeController::edit
* @see app/Http/Controllers/ChallengeController.php:95
* @route '/challenges/{challenge}/edit'
*/
edit.get = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::edit
* @see app/Http/Controllers/ChallengeController.php:95
* @route '/challenges/{challenge}/edit'
*/
edit.head = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ChallengeController::edit
* @see app/Http/Controllers/ChallengeController.php:95
* @route '/challenges/{challenge}/edit'
*/
const editForm = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::edit
* @see app/Http/Controllers/ChallengeController.php:95
* @route '/challenges/{challenge}/edit'
*/
editForm.get = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::edit
* @see app/Http/Controllers/ChallengeController.php:95
* @route '/challenges/{challenge}/edit'
*/
editForm.head = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\ChallengeController::store
* @see app/Http/Controllers/ChallengeController.php:85
* @route '/challenges'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/challenges',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ChallengeController::store
* @see app/Http/Controllers/ChallengeController.php:85
* @route '/challenges'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ChallengeController::store
* @see app/Http/Controllers/ChallengeController.php:85
* @route '/challenges'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ChallengeController::store
* @see app/Http/Controllers/ChallengeController.php:85
* @route '/challenges'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ChallengeController::store
* @see app/Http/Controllers/ChallengeController.php:85
* @route '/challenges'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\ChallengeController::update
* @see app/Http/Controllers/ChallengeController.php:111
* @route '/challenges/{challenge}'
*/
export const update = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/challenges/{challenge}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\ChallengeController::update
* @see app/Http/Controllers/ChallengeController.php:111
* @route '/challenges/{challenge}'
*/
update.url = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{challenge}', parsedArgs.challenge.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ChallengeController::update
* @see app/Http/Controllers/ChallengeController.php:111
* @route '/challenges/{challenge}'
*/
update.put = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\ChallengeController::update
* @see app/Http/Controllers/ChallengeController.php:111
* @route '/challenges/{challenge}'
*/
const updateForm = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ChallengeController::update
* @see app/Http/Controllers/ChallengeController.php:111
* @route '/challenges/{challenge}'
*/
updateForm.put = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

const challenges = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    aiSuggest: Object.assign(aiSuggest, aiSuggest),
    show: Object.assign(show, show),
    edit: Object.assign(edit, edit),
    store: Object.assign(store, store),
    update: Object.assign(update, update),
    offers: Object.assign(offers, offers),
}

export default challenges
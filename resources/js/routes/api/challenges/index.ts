import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
import offers from './offers'
/**
* @see \App\Http\Controllers\Api\ChallengeApiController::index
* @see app/Http/Controllers/Api/ChallengeApiController.php:18
* @route '/api/challenges'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/challenges',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::index
* @see app/Http/Controllers/Api/ChallengeApiController.php:18
* @route '/api/challenges'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::index
* @see app/Http/Controllers/Api/ChallengeApiController.php:18
* @route '/api/challenges'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::index
* @see app/Http/Controllers/Api/ChallengeApiController.php:18
* @route '/api/challenges'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::index
* @see app/Http/Controllers/Api/ChallengeApiController.php:18
* @route '/api/challenges'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::index
* @see app/Http/Controllers/Api/ChallengeApiController.php:18
* @route '/api/challenges'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::index
* @see app/Http/Controllers/Api/ChallengeApiController.php:18
* @route '/api/challenges'
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
* @see \App\Http\Controllers\Api\ChallengeApiController::mine
* @see app/Http/Controllers/Api/ChallengeApiController.php:37
* @route '/api/challenges/mine'
*/
export const mine = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mine.url(options),
    method: 'get',
})

mine.definition = {
    methods: ["get","head"],
    url: '/api/challenges/mine',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::mine
* @see app/Http/Controllers/Api/ChallengeApiController.php:37
* @route '/api/challenges/mine'
*/
mine.url = (options?: RouteQueryOptions) => {
    return mine.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::mine
* @see app/Http/Controllers/Api/ChallengeApiController.php:37
* @route '/api/challenges/mine'
*/
mine.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mine.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::mine
* @see app/Http/Controllers/Api/ChallengeApiController.php:37
* @route '/api/challenges/mine'
*/
mine.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: mine.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::mine
* @see app/Http/Controllers/Api/ChallengeApiController.php:37
* @route '/api/challenges/mine'
*/
const mineForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: mine.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::mine
* @see app/Http/Controllers/Api/ChallengeApiController.php:37
* @route '/api/challenges/mine'
*/
mineForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: mine.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::mine
* @see app/Http/Controllers/Api/ChallengeApiController.php:37
* @route '/api/challenges/mine'
*/
mineForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: mine.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

mine.form = mineForm

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::show
* @see app/Http/Controllers/Api/ChallengeApiController.php:55
* @route '/api/challenges/{challenge}'
*/
export const show = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/challenges/{challenge}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::show
* @see app/Http/Controllers/Api/ChallengeApiController.php:55
* @route '/api/challenges/{challenge}'
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
* @see \App\Http\Controllers\Api\ChallengeApiController::show
* @see app/Http/Controllers/Api/ChallengeApiController.php:55
* @route '/api/challenges/{challenge}'
*/
show.get = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::show
* @see app/Http/Controllers/Api/ChallengeApiController.php:55
* @route '/api/challenges/{challenge}'
*/
show.head = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::show
* @see app/Http/Controllers/Api/ChallengeApiController.php:55
* @route '/api/challenges/{challenge}'
*/
const showForm = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::show
* @see app/Http/Controllers/Api/ChallengeApiController.php:55
* @route '/api/challenges/{challenge}'
*/
showForm.get = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::show
* @see app/Http/Controllers/Api/ChallengeApiController.php:55
* @route '/api/challenges/{challenge}'
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
* @see \App\Http\Controllers\Api\ChallengeApiController::store
* @see app/Http/Controllers/Api/ChallengeApiController.php:88
* @route '/api/challenges'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/challenges',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::store
* @see app/Http/Controllers/Api/ChallengeApiController.php:88
* @route '/api/challenges'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::store
* @see app/Http/Controllers/Api/ChallengeApiController.php:88
* @route '/api/challenges'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::store
* @see app/Http/Controllers/Api/ChallengeApiController.php:88
* @route '/api/challenges'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\ChallengeApiController::store
* @see app/Http/Controllers/Api/ChallengeApiController.php:88
* @route '/api/challenges'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

const challenges = {
    index: Object.assign(index, index),
    mine: Object.assign(mine, mine),
    show: Object.assign(show, show),
    store: Object.assign(store, store),
    offers: Object.assign(offers, offers),
}

export default challenges
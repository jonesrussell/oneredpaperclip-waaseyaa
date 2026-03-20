import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\OfferController::store
* @see app/Http/Controllers/OfferController.php:18
* @route '/challenges/{challenge}/offers'
*/
export const store = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/challenges/{challenge}/offers',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\OfferController::store
* @see app/Http/Controllers/OfferController.php:18
* @route '/challenges/{challenge}/offers'
*/
store.url = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return store.definition.url
            .replace('{challenge}', parsedArgs.challenge.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\OfferController::store
* @see app/Http/Controllers/OfferController.php:18
* @route '/challenges/{challenge}/offers'
*/
store.post = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\OfferController::store
* @see app/Http/Controllers/OfferController.php:18
* @route '/challenges/{challenge}/offers'
*/
const storeForm = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\OfferController::store
* @see app/Http/Controllers/OfferController.php:18
* @route '/challenges/{challenge}/offers'
*/
storeForm.post = (args: { challenge: string | { slug: string } } | [challenge: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

const offers = {
    store: Object.assign(store, store),
}

export default offers
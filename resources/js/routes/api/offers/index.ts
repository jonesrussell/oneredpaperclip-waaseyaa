import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\OfferApiController::accept
* @see app/Http/Controllers/Api/OfferApiController.php:32
* @route '/api/offers/{offer}/accept'
*/
export const accept = (args: { offer: number | { id: number } } | [offer: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: accept.url(args, options),
    method: 'post',
})

accept.definition = {
    methods: ["post"],
    url: '/api/offers/{offer}/accept',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\OfferApiController::accept
* @see app/Http/Controllers/Api/OfferApiController.php:32
* @route '/api/offers/{offer}/accept'
*/
accept.url = (args: { offer: number | { id: number } } | [offer: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { offer: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { offer: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            offer: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        offer: typeof args.offer === 'object'
        ? args.offer.id
        : args.offer,
    }

    return accept.definition.url
            .replace('{offer}', parsedArgs.offer.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\OfferApiController::accept
* @see app/Http/Controllers/Api/OfferApiController.php:32
* @route '/api/offers/{offer}/accept'
*/
accept.post = (args: { offer: number | { id: number } } | [offer: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: accept.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\OfferApiController::accept
* @see app/Http/Controllers/Api/OfferApiController.php:32
* @route '/api/offers/{offer}/accept'
*/
const acceptForm = (args: { offer: number | { id: number } } | [offer: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: accept.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\OfferApiController::accept
* @see app/Http/Controllers/Api/OfferApiController.php:32
* @route '/api/offers/{offer}/accept'
*/
acceptForm.post = (args: { offer: number | { id: number } } | [offer: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: accept.url(args, options),
    method: 'post',
})

accept.form = acceptForm

/**
* @see \App\Http\Controllers\Api\OfferApiController::decline
* @see app/Http/Controllers/Api/OfferApiController.php:47
* @route '/api/offers/{offer}/decline'
*/
export const decline = (args: { offer: number | { id: number } } | [offer: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: decline.url(args, options),
    method: 'post',
})

decline.definition = {
    methods: ["post"],
    url: '/api/offers/{offer}/decline',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\OfferApiController::decline
* @see app/Http/Controllers/Api/OfferApiController.php:47
* @route '/api/offers/{offer}/decline'
*/
decline.url = (args: { offer: number | { id: number } } | [offer: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { offer: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { offer: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            offer: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        offer: typeof args.offer === 'object'
        ? args.offer.id
        : args.offer,
    }

    return decline.definition.url
            .replace('{offer}', parsedArgs.offer.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\OfferApiController::decline
* @see app/Http/Controllers/Api/OfferApiController.php:47
* @route '/api/offers/{offer}/decline'
*/
decline.post = (args: { offer: number | { id: number } } | [offer: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: decline.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\OfferApiController::decline
* @see app/Http/Controllers/Api/OfferApiController.php:47
* @route '/api/offers/{offer}/decline'
*/
const declineForm = (args: { offer: number | { id: number } } | [offer: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: decline.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\OfferApiController::decline
* @see app/Http/Controllers/Api/OfferApiController.php:47
* @route '/api/offers/{offer}/decline'
*/
declineForm.post = (args: { offer: number | { id: number } } | [offer: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: decline.url(args, options),
    method: 'post',
})

decline.form = declineForm

const offers = {
    accept: Object.assign(accept, accept),
    decline: Object.assign(decline, decline),
}

export default offers
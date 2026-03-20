import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\TradeApiController::confirm
* @see app/Http/Controllers/Api/TradeApiController.php:15
* @route '/api/trades/{trade}/confirm'
*/
export const confirm = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: confirm.url(args, options),
    method: 'post',
})

confirm.definition = {
    methods: ["post"],
    url: '/api/trades/{trade}/confirm',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\TradeApiController::confirm
* @see app/Http/Controllers/Api/TradeApiController.php:15
* @route '/api/trades/{trade}/confirm'
*/
confirm.url = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { trade: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { trade: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            trade: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        trade: typeof args.trade === 'object'
        ? args.trade.id
        : args.trade,
    }

    return confirm.definition.url
            .replace('{trade}', parsedArgs.trade.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\TradeApiController::confirm
* @see app/Http/Controllers/Api/TradeApiController.php:15
* @route '/api/trades/{trade}/confirm'
*/
confirm.post = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: confirm.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\TradeApiController::confirm
* @see app/Http/Controllers/Api/TradeApiController.php:15
* @route '/api/trades/{trade}/confirm'
*/
const confirmForm = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: confirm.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\TradeApiController::confirm
* @see app/Http/Controllers/Api/TradeApiController.php:15
* @route '/api/trades/{trade}/confirm'
*/
confirmForm.post = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: confirm.url(args, options),
    method: 'post',
})

confirm.form = confirmForm

const trades = {
    confirm: Object.assign(confirm, confirm),
}

export default trades
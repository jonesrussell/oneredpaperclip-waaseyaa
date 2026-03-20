import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\TradeController::update
* @see app/Http/Controllers/TradeController.php:17
* @route '/trades/{trade}'
*/
export const update = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/trades/{trade}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\TradeController::update
* @see app/Http/Controllers/TradeController.php:17
* @route '/trades/{trade}'
*/
update.url = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{trade}', parsedArgs.trade.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\TradeController::update
* @see app/Http/Controllers/TradeController.php:17
* @route '/trades/{trade}'
*/
update.patch = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\TradeController::update
* @see app/Http/Controllers/TradeController.php:17
* @route '/trades/{trade}'
*/
const updateForm = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TradeController::update
* @see app/Http/Controllers/TradeController.php:17
* @route '/trades/{trade}'
*/
updateForm.patch = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\TradeController::confirm
* @see app/Http/Controllers/TradeController.php:29
* @route '/trades/{trade}/confirm'
*/
export const confirm = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: confirm.url(args, options),
    method: 'post',
})

confirm.definition = {
    methods: ["post"],
    url: '/trades/{trade}/confirm',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\TradeController::confirm
* @see app/Http/Controllers/TradeController.php:29
* @route '/trades/{trade}/confirm'
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
* @see \App\Http\Controllers\TradeController::confirm
* @see app/Http/Controllers/TradeController.php:29
* @route '/trades/{trade}/confirm'
*/
confirm.post = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: confirm.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TradeController::confirm
* @see app/Http/Controllers/TradeController.php:29
* @route '/trades/{trade}/confirm'
*/
const confirmForm = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: confirm.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TradeController::confirm
* @see app/Http/Controllers/TradeController.php:29
* @route '/trades/{trade}/confirm'
*/
confirmForm.post = (args: { trade: number | { id: number } } | [trade: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: confirm.url(args, options),
    method: 'post',
})

confirm.form = confirmForm

const trades = {
    update: Object.assign(update, update),
    confirm: Object.assign(confirm, confirm),
}

export default trades
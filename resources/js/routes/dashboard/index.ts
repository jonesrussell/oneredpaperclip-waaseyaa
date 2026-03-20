import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\ChallengeController::challenges
* @see app/Http/Controllers/ChallengeController.php:56
* @route '/dashboard/challenges'
*/
export const challenges = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: challenges.url(options),
    method: 'get',
})

challenges.definition = {
    methods: ["get","head"],
    url: '/dashboard/challenges',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ChallengeController::challenges
* @see app/Http/Controllers/ChallengeController.php:56
* @route '/dashboard/challenges'
*/
challenges.url = (options?: RouteQueryOptions) => {
    return challenges.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ChallengeController::challenges
* @see app/Http/Controllers/ChallengeController.php:56
* @route '/dashboard/challenges'
*/
challenges.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: challenges.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::challenges
* @see app/Http/Controllers/ChallengeController.php:56
* @route '/dashboard/challenges'
*/
challenges.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: challenges.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ChallengeController::challenges
* @see app/Http/Controllers/ChallengeController.php:56
* @route '/dashboard/challenges'
*/
const challengesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: challenges.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::challenges
* @see app/Http/Controllers/ChallengeController.php:56
* @route '/dashboard/challenges'
*/
challengesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: challenges.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ChallengeController::challenges
* @see app/Http/Controllers/ChallengeController.php:56
* @route '/dashboard/challenges'
*/
challengesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: challenges.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

challenges.form = challengesForm

const dashboard = {
    challenges: Object.assign(challenges, challenges),
}

export default dashboard
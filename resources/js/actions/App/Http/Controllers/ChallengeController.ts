export function index() {
    return { url: '/challenges', method: 'get' as const };
}
export function create() {
    return { url: '/challenges/create', method: 'get' as const };
}
export function store() {
    return { url: '/challenges', method: 'post' as const };
}
export function show(challenge: string | { slug: string }) {
    const slug = typeof challenge === 'string' ? challenge : challenge.slug;
    return { url: `/challenges/${slug}`, method: 'get' as const };
}
export function edit(challenge: string | { slug: string }) {
    const slug = typeof challenge === 'string' ? challenge : challenge.slug;
    return { url: `/challenges/${slug}/edit`, method: 'get' as const };
}
export function update(challenge: string | { slug: string }) {
    const slug = typeof challenge === 'string' ? challenge : challenge.slug;
    return { url: `/challenges/${slug}`, method: 'put' as const };
}
export function aiSuggest() {
    return { url: '/challenges/ai-suggest', method: 'post' as const };
}
export default { index, create, store, show, edit, update, aiSuggest };

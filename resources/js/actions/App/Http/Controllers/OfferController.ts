export function store(challenge: number | { id: number }) {
    const id = typeof challenge === 'number' ? challenge : challenge.id;
    return { url: `/challenges/${id}/offers`, method: 'post' as const };
}
export function accept(offer: number | { id: number }) {
    const id = typeof offer === 'number' ? offer : offer.id;
    return { url: `/offers/${id}/accept`, method: 'post' as const };
}
export function decline(offer: number | { id: number }) {
    const id = typeof offer === 'number' ? offer : offer.id;
    return { url: `/offers/${id}/decline`, method: 'post' as const };
}
export default { store, accept, decline };

export function update(trade: number | { id: number }) {
    const id = typeof trade === 'number' ? trade : trade.id;
    return { url: `/trades/${id}`, method: 'patch' as const };
}
export function confirm(trade: number | { id: number }) {
    const id = typeof trade === 'number' ? trade : trade.id;
    return { url: `/trades/${id}/confirm`, method: 'post' as const };
}
export default { update, confirm };

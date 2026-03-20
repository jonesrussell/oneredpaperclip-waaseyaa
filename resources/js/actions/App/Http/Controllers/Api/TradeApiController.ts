export function confirm(trade: number | { id: number }) { const id = typeof trade === 'number' ? trade : trade.id; return { url: `/api/trades/${id}/confirm`, method: 'post' as const }; }
export default { confirm };

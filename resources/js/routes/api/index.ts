import challenges from './challenges'
import offers from './offers'
import trades from './trades'

const api = {
    challenges: Object.assign(challenges, challenges),
    offers: Object.assign(offers, offers),
    trades: Object.assign(trades, trades),
}

export default api
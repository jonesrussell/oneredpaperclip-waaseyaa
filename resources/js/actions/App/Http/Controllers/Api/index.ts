import ChallengeApiController from './ChallengeApiController'
import OfferApiController from './OfferApiController'
import TradeApiController from './TradeApiController'

const Api = {
    ChallengeApiController: Object.assign(ChallengeApiController, ChallengeApiController),
    OfferApiController: Object.assign(OfferApiController, OfferApiController),
    TradeApiController: Object.assign(TradeApiController, TradeApiController),
}

export default Api
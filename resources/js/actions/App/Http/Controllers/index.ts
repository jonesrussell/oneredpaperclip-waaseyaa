import SitemapController from './SitemapController'
import ChallengeController from './ChallengeController'
import OfferController from './OfferController'
import TradeController from './TradeController'
import ItemMediaController from './ItemMediaController'
import DashboardController from './DashboardController'
import NotificationController from './NotificationController'
import Dashboard from './Dashboard'
import Api from './Api'
import Settings from './Settings'

const Controllers = {
    SitemapController: Object.assign(SitemapController, SitemapController),
    ChallengeController: Object.assign(ChallengeController, ChallengeController),
    OfferController: Object.assign(OfferController, OfferController),
    TradeController: Object.assign(TradeController, TradeController),
    ItemMediaController: Object.assign(ItemMediaController, ItemMediaController),
    DashboardController: Object.assign(DashboardController, DashboardController),
    NotificationController: Object.assign(NotificationController, NotificationController),
    Dashboard: Object.assign(Dashboard, Dashboard),
    Api: Object.assign(Api, Api),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers
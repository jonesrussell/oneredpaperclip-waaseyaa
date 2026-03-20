import ArticleController from './ArticleController'
import UserController from './UserController'

const Admin = {
    ArticleController: Object.assign(ArticleController, ArticleController),
    UserController: Object.assign(UserController, UserController),
}

export default Admin
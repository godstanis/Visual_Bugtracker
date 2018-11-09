import Api from './Classes/Api';
import RouteFactory from './Classes/Route';

let teamApi = new Api(new RouteFactory());

teamApi.bindRoutes([
    {name: 'members', route: window.location.href, method: 'GET'},
    {name: 'attach', route: window.location.href+'/attach', method: 'POST'},
    {name: 'detach', route: window.location.href+'/detach', method: 'POST'},
    {name: 'search', route: window.location.href+'/search-member', method: 'GET'},
    {name: 'allow', route: window.location.href+'/allow', method: 'POST'},
    {name: 'disallow', route: window.location.href+'/disallow', method: 'POST'}
]);

export default teamApi;

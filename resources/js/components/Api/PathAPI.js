import Api from './Classes/Api';
import RouteFactory from './Classes/Route';

let pathApi = new Api(new RouteFactory());

pathApi.bindRoutes([
    {name: 'paths', route: window.location.href+'/paths', method: 'GET'},
]);

export default pathApi;

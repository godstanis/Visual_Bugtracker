import Api from './Classes/Api';
import RouteFactory from './Classes/Route';

let markerApi = new Api(new RouteFactory());

markerApi.bindRoutes([
    {name: 'markers', route: window.location.href+'/comment_points', method: 'GET'},
    {name: 'delete', route: window.location.href+'/comment_points', method: 'DELETE'},
]);

export default markerApi;

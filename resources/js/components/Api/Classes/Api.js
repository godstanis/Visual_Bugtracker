class ApiCollection {
    constructor(routeFactory) {
        this.routeFactory = routeFactory;
        this.routes = [];
    }

    bindRoutes(arr) {
        arr.forEach(elem => {
            this.bindRoute(elem.name, elem.route, elem.method)
        });
    }

    bindRoute(name, url, method) {
        let route = this.routeFactory.createRoute(name, url, method);
        this.routes.push(route);
    }

    getRouteObj(name) {
        return this.routes.filter(
            obj => {
                return obj.name === name;
            }
        )[0];
    }
}

export default ApiCollection;
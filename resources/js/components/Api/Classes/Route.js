
/*
    Unifies a route interface for the client classes.
 */
class Route {
    constructor(name, url, method) {
        this.name = name;
        this.url = url;
        this.method = method;
    }

    getName() {
        return this.name;
    }
    getPath() {
        return this.url;
    }
    getMethod() {
        return this.method;
    }
}
/*
    A route factory, that builds a route class.
 */
class RouteFactory {
    createRoute(name, url, method) {
        return new Route(name, url, method);
    }
}

export default RouteFactory;

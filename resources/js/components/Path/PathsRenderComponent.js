import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

import pathApi from '../Api/PathAPI';

class PathsRenderComponent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {paths:[]};
        this.api = props.api;
    }

    componentDidMount() {
        axios.get(this.api.getRouteObj('paths').getPath())
            .then((response) => {
            this.setState({paths:response.data});
        });
    }

    render() {
        return (
            <React.Fragment>
                {this.state.paths.map( (path) => <Path key={path.path_slug} path={path} /> )}
            </React.Fragment>
        )
    }
}

function Path(props) {
    return (
        <path
            id={props.path.path_slug}
            stroke={props.path.stroke}
            strokeWidth={props.path['stroke-width']}
            className="svg-element"
            fill="none"
            d={props.path.d}></path>
    )
}

if(document.getElementById('svg-area')) {
    console.log('PathsComponent initialized');
    ReactDOM.render(
        <PathsRenderComponent api={pathApi} />,
        document.getElementById('svg-area')
    );
}

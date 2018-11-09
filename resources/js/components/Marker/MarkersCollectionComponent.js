import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

import markerApi from '../Api/MarkerAPI';

import MarkerComponent from './MarkerComponent';

class MarkersCollectionComponent extends React.Component {
    constructor(props) {
        super(props);
        this.api = props.api;
        this.state = {comment_points:[]};
    }

    componentDidMount() {
        axios.get(this.api.getRouteObj('markers').getPath())
            .then((response) => {
                this.setState({comment_points:response.data});
            });
    }

    render() {
        return (
            <React.Fragment>
                {this.state.comment_points.map( function(comment_point) {
                    return (<MarkerComponent key={comment_point.id} api={this.api} comment_point={comment_point} />)
                    }.bind(this)
                )}
            </React.Fragment>
        )
    }
}

if(document.getElementById('markers-container')) {
    console.log('MarkerRenderComponent initialized');
    ReactDOM.render(
        <MarkersCollectionComponent api={markerApi} />,
        document.getElementById('markers-container')
    );

}

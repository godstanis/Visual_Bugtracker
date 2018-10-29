import React, { Component } from 'react';
import axios from 'axios';

class MarkerComponent extends React.Component {
    constructor(props) {
        super(props);
        this.comment_point = props.comment_point;
        this.delete_href = window.location.href+'/comment_points';
    }

    deleteButtonClick(e) {
        e.preventDefault();

        let url = $(e.target).attr('href');
        if(url === undefined) { // if clicked on icon inside <a>
            url = $(e.target).closest('a').attr('href');
            let token = $(e.target).closest('a').attr('data-token');
        }

        axios.delete(url)
            .then((response) => {
                console.log(response)
            });
    }

    render() {
        const display_block = {display: 'block'};
        const position_style = {
            transform: `translate(${this.comment_point.position_x}px, ${this.comment_point.position_y}px)`
        };

        return (
            <div
                id={"marker_id_" + this.comment_point.id}
                style={position_style}
                className="comment-point-marker">

                <a href={this.delete_href+'/'+this.comment_point.id} onClick={this.deleteButtonClick.bind(this)} className="btn btn-danger btn-xs pull-right delete-marker-btn">
                    <span className="glyphicon glyphicon-trash"></span>
                </a>
                <span style={display_block}>
                                {this.comment_point.text}
                            </span>
                {this.comment_point.issue && ( // if issue exists
                    <span className="text-muted" style={display_block}>
                                    <a className="title-link" href={this.comment_point.issue.url}>
                                        <span>#{this.comment_point.issue.id} <b>{this.comment_point.issue.title}</b></span>
                                    </a>
                                </span>
                )}
                <span className="text-muted small">Created by {this.comment_point.creator.name}</span>
            </div>
        )
    }
}

export default MarkerComponent;

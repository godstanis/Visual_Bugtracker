import React, { Component } from 'react';
import axios from 'axios';

class Ability extends React.Component {
    constructor(props) {
        super(props);
        this.api = this.props.api;
    }

    updateMembers() {
        this.props.updateMembers();
    }

    setAbility(e) {
        e.preventDefault();
        let userName = this.props.member.name;
        let ability = e.target.dataset.ability;
        console.log(ability);
        axios.post(this.api.getRouteObj('allow').getPath() , {user:userName, ability_name:ability})
            .then((response) => {
                this.updateMembers();
            }).catch(error => {});
    }

    removeAbility(e) {
        e.preventDefault();
        let userName = this.props.member.name;
        let ability = e.target.dataset.ability;
        console.log(ability);
        axios.post(this.api.getRouteObj('disallow').getPath() , {user:userName, ability_name:ability})
            .then((response) => {
                this.updateMembers();
            }).catch(error => {});
    }

    render() {
        return(
            <span >
                {this.props.abilities.manage === false &&
                    <a className="btn btn-primary btn-xs ability-btn member-control-element"
                       href="#"
                       data-ability="manage"
                       onClick={this.setAbility.bind(this)}>Set as manager</a>
                }
                {this.props.abilities.manage !== false &&
                    <a className="btn btn-primary btn-xs ability-btn member-control-element"
                       href="#"
                       data-ability="manage"
                       onClick={this.removeAbility.bind(this)}>Remove manager role</a>
                }
            </span>
        )
    }
}

export default Ability;

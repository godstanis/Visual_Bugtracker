import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import MemberComponent from './MemberComponent';
import SearchForm from './SearchMemberFormComponent';

import teamApi from '../Api/TeamAPI';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

class TeamComponent extends React.Component {
    constructor(props) {
        super(props);
        this.api = props.api;
        this.state = {users:[], members:[]};

        this.csrf = Laravel.csrfToken;

        this.authCanDelete = window.auth_user.canRemoveMember;
        this.authCanManage = window.auth_user.canManage;
    }

    componentDidMount() {
        this.updateMembersListRequest();
    }

    // Updates member list wia sending a get request to the server
    updateMembersListRequest() {
        console.log('updating members');
        axios.get(this.api.getRouteObj('members').getPath())
            .then((response) => {
                this.setState({members:response.data});
            }).catch(error => {});
    }

    // Send a request to attach a member
    attachUser(e) {
        e.preventDefault();
        let userName = e.target.dataset.userName;
        axios.post(this.api.getRouteObj('attach').getPath() , {name:userName})
            .then((response) => {
                this.updateMembersListRequest();
            }).catch(error => {});
    }

    // Send a request to detach a member
    detachUser(e) {
        e.preventDefault();
        axios.post(e.target.href)
            .then((response) => {
                this.updateMembersListRequest();
            });
    }

    render() {
        let links = {
            attach: this.api.getRouteObj('attach').getPath(),
            detach: this.api.getRouteObj('detach').getPath(),
            search: this.api.getRouteObj('search').getPath(),
        };

        return (
                <div>
                    <table className="table">
                        <tbody>
                            {this.state.members.map( (member) =>
                                <MemberComponent
                                key={'member_'+member.name}
                                api={this.api}
                                member={member} links={links}
                                canDelete={this.authCanDelete}
                                canManage={this.authCanManage}
                                detachUser={this.detachUser.bind(this)}
                                updateMembers={this.updateMembersListRequest.bind(this)}/> )}
                        </tbody>
                    </table>
                    { (this.authCanDelete || this.authCanManage) &&
                        <div className="col-md-6 col-md-offset-3">
                            <SearchForm api={this.api} csrf={this.csrf} links={links} attachUser={this.attachUser.bind(this)}/>
                        </div>
                    }
                </div>
        )
    }
}

if(document.getElementById('search-team-component')) {
    console.log('TeamComponent initialized');
    ReactDOM.render(
        <TeamComponent api={teamApi} />,
        document.getElementById('search-team-component')
    );
}

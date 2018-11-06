import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import MemberComponent from './MemberComponent';
import SearchForm from './SearchMemberFormComponent';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

class TeamComponent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {users:[], members:[]};
        this.members_href = window.location.href; // ajax
        this.attach_href = window.location.href+'/attach';
        this.detach_href = window.location.href+'/detach';
        this.search_href = window.location.href+'/search-member';
        this.csrf = Laravel.csrfToken;

        this.user_can_delete_members = window.auth_user.canRemoveMember;
    }

    componentDidMount() {
        this.updateMembersListRequest();
    }

    // Updates member list wia sending a get request to the server
    updateMembersListRequest() {
        axios.get(this.members_href)
            .then((response) => {
                this.setState({members:response.data});
            }).catch(error => {});
    }

    // Send a request to attach a member
    attachUser(e) {
        e.preventDefault();
        let userName = e.target.dataset.userName;
        axios.post(this.attach_href , {name:userName})
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
            attach: this.attach_href,
            detach: this.detach_href,
            search: this.search_href,
        };

        return (
                <div>
                    <table className="table">
                        <tbody>
                            {this.state.members.map( (member) => <MemberComponent key={'member_'+member.name} member={member} links={links} canDelete={this.user_can_delete_members} detachUser={this.detachUser.bind(this)}/> )}
                        </tbody>
                    </table>

                    <div className="col-md-6 col-md-offset-3">
                        <SearchForm csrf={this.csrf} links={links} attachUser={this.attachUser.bind(this)}/>
                    </div>
                </div>
        )
    }
}

if(document.getElementById('search-team-component')) {
    console.log('TeamComponent initialized');
    ReactDOM.render(
        <TeamComponent />,
        document.getElementById('search-team-component')
    );
}

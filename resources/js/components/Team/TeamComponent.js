import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

console.log('test');

class TeamComponent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {users:[], members:[]};
        this.members_href = window.location.href; // ajax
        this.attach_href = window.location.href+'/attach';
        this.detach_href = window.location.href+'/detach';
        this.search_href = window.location.href+'/search-member';
        this.csrf = Laravel.csrfToken;
        this.name_input_value = '';

        this.user_can_delete_members = window.auth_user.canRemoveMember;

        this.updateMembersListRequest();
    }

    // Search users on input change
    updateInputValue(e) {
        this.name_input_value = e.target.value;
        this.searchUser(e.target.value);
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

    // Send a search request to the server and update search output state
    searchUser(name) {
        axios.get(this.search_href, {params:{name:name}})
            .then((response) => {
                this.setState({users:response.data});
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
                            {this.state.members.map( (member) => <MembersList key={'member_'+member.name} member={member} links={links} canDelete={this.user_can_delete_members} detachUser={this.detachUser.bind(this)}/> )}
                        </tbody>
                    </table>

                    <div className="col-md-6 col-md-offset-3">
                        <SearchForm csrf={this.csrf} links={links} onChange={this.updateInputValue.bind(this)}/>

                        <table className="table table-inverse">
                            <tbody className="user-name-search-results">
                            {this.state.users.map( (user) => <FoundUser key={user.name} user={user} attachUser={this.attachUser.bind(this)}/> )}
                            </tbody>
                        </table>
                    </div>
                </div>
        )
    }
}

class MembersList extends React.Component {
    constructor(props) {
        super(props);
        this.props = props;
    }

    render() {
        return (
            <tr><td>
                <a href={this.props.member.profile_url}>
                    <span>@</span>{this.props.member.name}
                    <img className="user-profile-image" src={this.props.member.profile_image_url} alt="" width="20px"/>
                    {" "}
                </a>
                {this.props.canDelete &&
                    <a href={this.props.links.detach+'/'+this.props.member.name} className="member-delete-form btn btn-danger btn-xs glyphicon glyphicon-remove" onClick={this.props.detachUser.bind(this)}></a>
                }
            </td></tr>
        )
    }
}

class SearchForm extends React.Component {
    constructor(props) {
        super(props);
        this.props = props;
    }

    render() {
        return (
            <form action={this.props.links.attach} method="POST">
                <div className="input-group ">
                    <span className="input-group-addon" id="sizing-addon2">@</span>
                    <input className="form-control user-name-search-input" type="text" name="user_name"
                           placeholder="Имя пользователя" onChange={this.props.onChange.bind(this)} />
                </div>
                <input type="hidden" name="_token" value={this.props.csrf}/>
            </form>
        )
    }
}

function FoundUser(props) {
    return (
        <tr><td>
            <a href={props.user.profile_url}>
                <span>@</span>{props.user.name}
            </a>
            <img className="user-profile-image" src={props.user.profile_image_url} alt="" width="20px"/>
                <span className="insert-in-input-block">
                    {" "}
                    <a data-user-name={props.user.name} onClick={props.attachUser} className="btn btn-success btn-xs insert-user-in-input glyphicon glyphicon-plus"></a>
                </span>
        </td></tr>
    )
}

if(document.getElementById('search-team-component')) {
    console.log('TeamComponent initialized');
    ReactDOM.render(
        <TeamComponent />,
        document.getElementById('search-team-component')
    );
}

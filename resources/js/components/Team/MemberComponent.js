import React, { Component } from 'react';

class Member extends React.Component {
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
                <span>
                    <MemberControlPanel
                        key={this.props.member.name}
                        member={this.props.member}
                        canDelete={this.props.canDelete}
                        detach={this.props.links.detach+'/'+this.props.member.name}
                        detachUser={this.props.detachUser.bind(this)}/>
                </span>
            </td></tr>
        )
    }
}

class MemberControlPanel extends React.Component {
    constructor(props) {
        super(props);
    }

    roles() {
        let roles = [];
        if (this.props.member.abilities['create'] === true) {
            roles.push(<CreatorBadge key={this.props.member.name} />);
        }
        if (this.props.member.abilities['manage'] === true) {
            roles.push(<ManagerBadge key={this.props.member.name} />);
        }
        return roles;
    }

    render() {
        return (
            <span className="controls">
                <span>
                    {(this.props.canDelete) &&
                    <DeleteButton detach={this.props.detach} detachUser={this.props.detachUser.bind(this)} />
                    }
                </span>
                <span>{this.roles()}</span>
            </span>
        )
    }
}

function DeleteButton(props) {
    return (
        <a href={props.detach}
           className="member-delete-form btn btn-danger btn-xs glyphicon glyphicon-remove"
           onClick={props.detachUser}></a>
    );
}

function CreatorBadge(props) {
    return (
        <span> creator</span>
    );
}

function ManagerBadge(props) {
    return (
        <span> manager</span>
    );
}

export default Member;

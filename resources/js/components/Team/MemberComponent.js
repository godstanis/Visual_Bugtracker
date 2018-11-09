import React, { Component } from 'react';
import Ability from './AbilityComponent';

class Member extends React.Component {
    constructor(props) {
        super(props);
        this.props = props;
        this.api = props.api;
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
                            api={this.api}
                            member={this.props.member}
                            canDelete={this.props.canDelete}
                            canManage={this.props.canManage}
                            detach={this.props.links.detach+'/'+this.props.member.name}
                            detachUser={this.props.detachUser.bind(this)}
                            updateMembers={this.props.updateMembers.bind(this)}/>
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
            roles.push(<CreatorBadge key={'creator_badge_'+this.props.member.name} />);
        }
        if (this.props.member.abilities['manage'] === true) {
            roles.push(<ManagerBadge key={'manager_badge_'+this.props.member.name} />);
        }
        return roles;
    }

    render() {
        return (
            <span className="controls">
                <span>
                    {(this.props.canManage || this.props.canDelete) &&
                        <DeleteButton key={'delete_button_'+this.props.member.name}
                                      detach={this.props.detach}
                                      detachUser={this.props.detachUser.bind(this)} />
                    }
                </span>
                {(this.props.canDelete) &&
                <Ability key={'ability_'+this.props.member.name}
                         api={this.props.api}
                         member={this.props.member}
                         abilities={this.props.member.abilities}
                         updateMembers={this.props.updateMembers.bind(this)} />
                }
                {this.roles()}
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
        <span className="small creator-badge ability-badge member-control-element">creator</span>
    );
}

function ManagerBadge(props) {
    return (
        <span className="small manager-badge ability-badge member-control-element">manager</span>
    );
}

export default Member;

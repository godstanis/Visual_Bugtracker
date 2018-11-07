import React, { Component } from 'react';
import axios from "axios";

class SearchForm extends React.Component {
    constructor(props) {
        super(props);
        this.props = props;
        this.state = {users:[]};
        this.search_href = window.location.href+'/search-member';
    }

    // Search users on input change
    updateInputValue(e) {
        if(e.target.value.length >= 1) {
            console.log('input updated');
            this.searchUser(e.target.value);
        }
    }

    // Send a search request to the server and update search output state
    searchUser(name) {
        axios.get(this.search_href, {params:{name:name}})
            .then((response) => {
                console.log(response.data);
                this.setState({users:response.data});
            });
    }

    render() {
        return (
            <div>
                <form action={this.props.links.attach} method="POST">
                    <div className="input-group ">
                        <span className="input-group-addon" id="sizing-addon2">@</span>
                        <input className="form-control user-name-search-input"
                               onChange={this.updateInputValue.bind(this)}
                               type="text"
                               name="user_name"
                               placeholder="User Name" onChange={this.updateInputValue.bind(this)} />
                    </div>
                    <input type="hidden" name="_token" value={this.props.csrf}/>
                </form>
                <table className="table table-inverse">
                    <tbody className="user-name-search-results">
                    {this.state.users.map( (user) => <FoundUser key={user.name} user={user} attachUser={this.props.attachUser.bind(this)}/> )}
                    </tbody>
                </table>
            </div>
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
                <a data-user-name={props.user.name}
                   onClick={props.attachUser}
                   className="btn btn-success btn-xs insert-user-in-input glyphicon glyphicon-plus"></a>
                </span>
        </td></tr>
    )
}

export default SearchForm;

import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Card from './Card';

/**
 * Dashboard controls state of team cards
 *
 * @author Isaac Buitrago
 */
class Dashboard extends React.Component
{

    constructor(props)
    {
        super(props);

        this.state = {

            teams: [],

            currentTeam: null,
        }
    }

    componentDidCatch(error, info)
    {
        console.error(`${error}: ${info}`);
    }

    /**
     * Queries API for the set of teams of the current user
     * @returns teams for the current user, or null if none are available
     */
    componentDidMount()
    {
        axios.get("http://teamleader.test/api/teams")
            .then(response => {

                console.log(response);

                this.setState({teams: response.data});
                })
            .catch(function(error){

                console.log(error)

                });
    }

    renderTeams()
    {
        return this.state.teams.map( team => {

            return <Card title={team.name} key={team.id}/>
        });
    }

    render()
    {
        const teams = this.state.teams;

        if(teams !== undefined)
        {
            return this.renderTeams();
        }

        else
        {
            return <Card title={"New team"}/>
        }
    }

}



// ========================================

ReactDOM.render(
    <Dashboard />,
    document.getElementById('root')
);

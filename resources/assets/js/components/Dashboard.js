import React, { Component } from 'react';
import ReactDOM from 'react-dom';

/**
 * Dashboard controls state of team cards
 */
class Dashboard extends React.Component
{

    constructor(props)
    {
        super(props);

        this.state = {

            cards: Array(1).fill(null),

        }
    }

    render()
    {
        return(<Card title={"Utsa invest"}/>);
    }
}

function Card(props)
{
    return(

        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-5">
                    <div className="card">

                        <div className="card-header">{props.title}</div>

                        <div className="card-body card-banner">

                            // TODO wrap team logo in body

                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}


// ========================================

ReactDOM.render(
    <Dashboard />,
    document.getElementById('root')
);

import React from 'react';

/**
 * Displays information for a team
 * @param props
 * @returns {*}
 * @constructor
 */
export default function Card(props)
{
    return(

        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-5">
                    <div className="card">

                        <div className="card-header">{props.title}</div>

                        <div className="card-body card-banner">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

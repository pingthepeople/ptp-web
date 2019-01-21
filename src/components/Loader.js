import React from 'react';

const Loader = ({msg}) => (
    <div className="bill-list__loading">
        <div className="ping-loader"></div>
        <p>{msg}</p>
    </div>
)

export default Loader;
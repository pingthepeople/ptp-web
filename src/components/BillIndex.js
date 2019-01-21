import React from 'react';

const BillIndex = ({children}) => (
    <div className="bill-list bill-list--all-bills">
        <div className="bill-list__bills">
            {children}
        </div>
    </div>
);

export default BillIndex;

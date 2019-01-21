import React from 'react';

export const ItemList = ({ items, pluralizer, render=(item) => `${item.Name}`}) => (
    <>
        {(items && items.length>0) && 
            <div className="info">
                <div className="info__label">
                    {pluralizer(items.length)}
                </div>
                <div className="info__body">
                    {items.map((item, i) =>
                        <div key={i}>
                            {render(item)}
                        </div>
                    )}
                </div>
            </div>}
    </>
);
export const LegislatorList = ({ items, pluralizer }) => (
    <ItemList
        items={items}
        pluralizer={pluralizer}
        render={item => `(${item.Chamber[0]}) ${item.LastName}`}
    />
);
export const CommitteeList = ({ items, pluralizer }) => (
    <ItemList
        items={items}
        pluralizer={pluralizer}
        render={item => `(${item.Chamber[0]}) ${item.Name}`}
    />
);

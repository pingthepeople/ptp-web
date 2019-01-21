import React from 'react';

const pluralizeIs = n => (n === 1 ? "is" : "are");
const pluralizeBill = n => (n === 1 ? "bill" : "bills");
const pluralizeMatch = n => (n === 1 ? "matches" : "match");

const Filters = (props) => (
    <div className="filters">
        <form className="filters__search search" submit-prevent="filterBillHandler">
            <input className="search__input" type="search" autoComplete="off" v-model="q" placeholder="Search by bill number, keyword, author, committee, subject..."/>
            <input className="search__submit button" type="submit" value="Search"/>
        </form>

        {props.isFilterApplied &&
            <div className="filters__message">
                <div>
                    Here {pluralizeIs(props.bills.length)} the {props.bills.length} {pluralizeBill(props.bills.length)} that {pluralizeMatch(props.bills.length)} your search. <button className="button--plain" clickprevent="clearSearch">Clear search</button>
                </div>
            </div>
        }
        {(props.isFilterApplied && props.bills.length === 0) &&
            <div className="filters__no-result">
                Your search did not return any results.  <button className="button--plain" clickprevent="clearSearch">Clear search</button>
            </div>
        }
    </div>
)

export default Filters;
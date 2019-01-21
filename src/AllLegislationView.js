import React from 'react';
import { connect } from 'react-redux';
import Bill from './Bill';
import BillIndex from './components/BillIndex';
import Loader from './components/Loader';
import Filters from './components/Filters';
import Pager from './components/Pager';
import { pageGetter, pageSetter, paginate } from './utils';

class View extends React.Component {
    state = {
        pageLength: 50,
    }

    render = () => {
        const visibleBills = paginate(
            this.props.bills,
            pageGetter(), 
            this.state.pageLength);

        return (
            <div>
                <h1 className="section-title">All Legislation</h1>

                {!this.props.isLoaded && 
                    <Loader msg="Loading legislative items"/>
                }

                {this.props.isLoaded && 
                    <>
                        <Filters />
                        <Pager 
                            pageGetter={pageGetter} 
                            pageSetter={pageSetter} 
                            nItems={this.props.bills.length} 
                            pageLength={this.state.pageLength} />

                        <BillIndex>
                            {visibleBills.map((bill, i) => 
                                <Bill key={i} bill={bill}/>
                            )}
                        </BillIndex>

                        <Pager 
                            pageGetter={pageGetter} 
                            pageSetter={pageSetter} 
                            nItems={this.props.bills.length} 
                            pageLength={this.state.pageLength} />
                    </>
                }

                {(this.props.isLoaded && (!this.props.bills || this.props.bills.length<1)) &&
                    <div className="bill-list__no-bills">
                        <p className="bill-list__no-bills-text">
                            There are no bills available yet for this session
                        </p>
                    </div>
                }
            </div>
        );
    }   
};

const mapStateToProps = (state) => ({
    bills: state.bills.all,
    isLoaded: state.bills.isLoaded,
    legislators: state.legislators.all,
    subjects: state.subjects.all,
    committees: state.committees.all
});

export default connect(
    mapStateToProps
  )(View);

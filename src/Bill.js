import React from 'react';
import { connect } from 'react-redux';
import BillComponent from './components/Bill';

const byIds = (items, ids) => (items ? items.filter(item => ids && ids.includes(item.Id)) : [])

class Bill extends React.Component {
    render() {
        const authors = byIds(this.props.legislators, this.props.bill.authorIds);
        const coauthors = byIds(this.props.legislators, this.props.bill.coauthorIds);
        const sponsors = byIds(this.props.legislators, this.props.bill.sponsorIds);
        const cosponsors = byIds(this.props.legislators, this.props.bill.cosponsorIds);
        const subjects = byIds(this.props.subjects, this.props.bill.subjectIds);
        const committees = byIds(this.props.committees, this.props.bill.committeeIds);

        return <BillComponent 
            bill={this.props.bill} 
            authors={authors}
            coauthors={coauthors}
            sponsors={sponsors}
            cosponsors={cosponsors}
            subjects={subjects}
            committees={committees} />
    }
};

const mapStateToProps = (state) => ({
    legislators: state.legislators.all,
    subjects: state.subjects.all,
    committees: state.committees.all
});

export default connect(
    mapStateToProps
  )(Bill);
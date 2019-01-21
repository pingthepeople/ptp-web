import { _fetchBills, _fetchLegislators, _fetchSubjects, _fetchCommittees } from '../api';

export const RECEIVE_BILLS = 'RECEIVE_BILLS';
export const RECEIVE_LEGISLATORS = 'RECEIVE_LEGISLATORS';
export const RECEIVE_SUBJECTS = 'RECEIVE_SUBJECTS';
export const RECEIVE_COMMITTEES = 'RECEIVE_COMMITTEES';

const receiveBills = bills => ({
    type: RECEIVE_BILLS,
    bills
});

export const fetchBills = () => dispatch => {
    _fetchBills()
        .then(res => res.data)
        .then(res => {
            dispatch(receiveBills(res));
        });
};

const receiveLegislators = legislators => ({
    type: RECEIVE_LEGISLATORS,
    legislators
});

export const fetchLegislators = () => dispatch => {
    _fetchLegislators()
        .then(res => res.data)
        .then(res => {
            dispatch(receiveLegislators(res))
        });
};

const receiveSubjects = subjects => ({
    type: RECEIVE_SUBJECTS,
    subjects
});

export const fetchSubjects = () => dispatch => {
    _fetchSubjects()
        .then(res => res.data)
        .then(res => {
            dispatch(receiveSubjects(res))
        });
};

const receiveCommittees = committees => ({
    type: RECEIVE_COMMITTEES,
    committees
});

export const fetchCommittees = () => dispatch => {
    _fetchCommittees()
        .then(res => res.data)
        .then(res => {
            dispatch(receiveCommittees(res))
        });
};
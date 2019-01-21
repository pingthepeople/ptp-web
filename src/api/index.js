import http from 'axios';

const apiRoot = "http://localhost:3001";
const billsEndpoint = `${apiRoot}/bills`;
const legislatorsEndpoint = `${apiRoot}/legislators`;
const subjectsEndpoint = `${apiRoot}/subjects`;
const committeesEndpoint = `${apiRoot}/committees`;

export const _fetchBills = () => {
    return http.get(billsEndpoint);
};

export const _fetchLegislators = () => {
    return http.get(legislatorsEndpoint);
};

export const _fetchSubjects = () => {
    return http.get(subjectsEndpoint);
};

export const _fetchCommittees = () => {
    return http.get(committeesEndpoint);
};

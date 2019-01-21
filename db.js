const faker = require('faker');

const rndBetween = (min, max) => parseInt(Math.random() * (max - min) + min);
const arrayOfLengthBetween = (min, max) => [...Array(rndBetween(min, max+1))];
const rndChamber = () => faker.random.boolean() ? "House" : "Senate";
const chamberInitial = (chamber) => chamber[0];
const capitalizeFirstLetter = (str) => str.charAt(0).toUpperCase() + str.slice(1);

const nBills = 1500;
const nLegislators = 20;
const nSubjects = 20;
const nCommittees = 20;
const rndLegislatorId = () => rndBetween(0, nLegislators);
const rndSubjectId = () => rndBetween(0, nSubjects);
const rndCommitteeId = () => rndBetween(0, nCommittees);

const rndBill = (id) => {
    const chamber = rndChamber();
    const title = capitalizeFirstLetter(faker.lorem.words(rndBetween(2, 8)));
    const coauthorIds = arrayOfLengthBetween(2,8).map(() => rndLegislatorId());
    const sponsorIds = arrayOfLengthBetween(1,4).map(() => rndLegislatorId());
    const cosponsorIds = arrayOfLengthBetween(2,8).map(() => rndLegislatorId());
    const subjectIds = arrayOfLengthBetween(1,3).map(() => rndSubjectId());
    const committeeIds = arrayOfLengthBetween(0,2).map(() => rndCommitteeId());
    return {
        Id: id,
        Title: `${title}.`,
        Chamber: chamber,
        Name: `${chamberInitial(chamber)}B ${rndBetween(1,1000)}`,
        Description: faker.lorem.sentences(rndBetween(2, 150)),
        authorIds: [rndLegislatorId()],
        coauthorIds,
        sponsorIds,
        cosponsorIds,
        subjectIds,
        committeeIds
    };
};

const rndLegislator = (id) => ({
    Id: id,
    FirstName: faker.name.firstName(),
    LastName: faker.name.lastName(),
    Chamber: rndChamber()
});

const rndSubject = id => ({
    Id: id,
    Name: `${faker.company.bsNoun()}, ${faker.company.bsNoun()}, and ${faker.company.bsNoun()}`
});

const rndCommittee = id => ({
    Id: id,
    Chamber: rndChamber(),
    Name: faker.company.bs()
});

module.exports = () => {
    const bills = 
        [...Array(nBills).keys()]
        .map(i => rndBill(i))
    const legislators = 
        [...Array(nLegislators).keys()]
        .map(i => rndLegislator(i))
    const subjects =
        [...Array(nSubjects).keys()]
        .map(i => rndSubject(i))
    const committees = 
        [...Array(nCommittees).keys()]
        .map(i => rndCommittee(i))

    return {
        bills,
        legislators,
        subjects,
        committees
    };
};

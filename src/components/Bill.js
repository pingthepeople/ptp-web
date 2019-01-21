import React from 'react';
import { 
    pluralizeAuthor,
    pluralizeCoauthor,
    pluralizeSponsor,
    pluralizeCosponsor,
    pluralizeSubjects,
    pluralizeCommittees } from '../utils';
import { ItemList, LegislatorList, CommitteeList } from './Lists';

const Bill = ({ bill, authors, coauthors, sponsors, cosponsors, subjects, committees }) => (
    <div className="bill">
        <div className="bill__inner">
            <header className="bill__header">
                <div className="bill__actions">
                    <button className={`switch ${bill.isTracked ? 'is-on' : ''}`}>
                        <span className="u-sr-only">
                            {bill.isTracked ? "Stop" : "Start"} tracking {bill.Name}
                        </span>
                        <span aria-hidden="true">Tracking <strong>{bill.isTracked ? 'on' : 'off'}</strong></span>
                    </button>
                </div>
                <div className="bill__header-meta">
                    <div className="bill__name-and-title">
                        <a href={`/bills/${bill.Name}`}>
                            <h3 className="bill__name">
                                { bill.Name }
                            </h3>
                            <p className="bill__title">
                                { bill.Title }
                            </p>
                        </a>
                    </div>
                    {bill.isTracked && 
                        <div v-if="isTracked" className="bill__is-tracked" aria-hidden="true">
                            You are tracking this legislation
                        </div>
                    }
                    <div className="bill__meta">
                        <LegislatorList
                            items={authors}
                            pluralizer={pluralizeAuthor} />
                        <LegislatorList
                            items={coauthors}
                            pluralizer={pluralizeCoauthor} />
                        <LegislatorList
                            items={sponsors}
                            pluralizer={pluralizeSponsor} />
                        <LegislatorList
                            items={cosponsors}
                            pluralizer={pluralizeCosponsor} />
                        <ItemList
                            items={subjects}
                            pluralizer={pluralizeSubjects} />
                        <CommitteeList
                            items={committees}
                            pluralizer={pluralizeCommittees} />
                    </div>
                </div>
            </header>
            <div className="bill__body info">
                <div className='info__label'>
                    Description
                </div>
                <div className="info__body info__body--long">
                    <div>{ bill.Description }</div>
                </div>
            </div>
        </div>
    </div>
);

export default Bill;

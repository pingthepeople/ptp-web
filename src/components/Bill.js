import React from 'react';
import { 
    pluralizeAuthor,
    pluralizeCoauthor,
    pluralizeSponsor,
    pluralizeCosponsor,
    pluralizeSubjects,
    pluralizeCommittees,
    truncate } from '../utils';
import { ItemList, LegislatorList, CommitteeList } from './Lists';

const truncatedLen = 250;
class Bill extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isDescriptionTruncated: true
        }
        this.handleToggleTruncate = this.handleToggleTruncate.bind(this);
    }

    handleToggleTruncate() {
        this.setState({isDescriptionTruncated: !this.state.isDescriptionTruncated})
    }

    render() {
        return (
            <div className="bill">
                <div className="bill__inner">
                    <header className="bill__header">
                        <div className="bill__actions">
                            <button className={`switch ${this.props.bill.isTracked ? 'is-on' : ''}`}>
                                <span className="u-sr-only">
                                    {this.props.bill.isTracked ? "Stop" : "Start"} tracking {this.props.bill.Name}
                                </span>
                                <span aria-hidden="true">Tracking <strong>{this.props.bill.isTracked ? 'on' : 'off'}</strong></span>
                            </button>
                        </div>
                        <div className="bill__header-meta">
                            <div className="bill__name-and-title">
                                <a href={`/bills/${this.props.bill.Name}`}>
                                    <h3 className="bill__name">
                                        { this.props.bill.Name }
                                    </h3>
                                    <p className="bill__title">
                                        { this.props.bill.Title }
                                    </p>
                                </a>
                            </div>
                            {this.props.bill.isTracked && 
                                <div className="bill__is-tracked">
                                    You are tracking this legislation
                                </div>
                            }
                            <div className="bill__meta">
                                <LegislatorList
                                    items={this.props.authors}
                                    pluralizer={pluralizeAuthor} />
                                <LegislatorList
                                    items={this.props.coauthors}
                                    pluralizer={pluralizeCoauthor} />
                                <LegislatorList
                                    items={this.props.sponsors}
                                    pluralizer={pluralizeSponsor} />
                                <LegislatorList
                                    items={this.props.cosponsors}
                                    pluralizer={pluralizeCosponsor} />
                                <ItemList
                                    items={this.props.subjects}
                                    pluralizer={pluralizeSubjects} />
                                <CommitteeList
                                    items={this.props.committees}
                                    pluralizer={pluralizeCommittees} />
                            </div>
                        </div>
                    </header>
                    <div className="bill__body info">
                        <div className='info__label'>
                            Description
                        </div>
                        <div className="info__body info__body--long">
                            <div>
                                { truncate(
                                    this.props.bill.Description, 
                                    this.state.isDescriptionTruncated ? truncatedLen : 0
                                ) }
                            </div>
                            {this.props.bill.Description.length > truncatedLen && (
                                <button onClick={this.handleToggleTruncate}
                                    className="bill__description-toggle button--plain">
                                    {this.state.isDescriptionTruncated ? "Show" : "Hide"} full description
                                </button>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Bill;

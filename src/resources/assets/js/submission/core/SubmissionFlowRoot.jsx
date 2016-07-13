import React from 'react'
import { connect } from 'react-redux'

import { SubmissionBase } from '../base_components'
import SubmissionNav from './SubmissionNav'


const steps = new Map([
    // The steps key is some metadata about the steps, maybe redundant but we'll leave it for now.
    ['scoreboard', {name: 'Scoreboard'}],
    ['applications', {name: 'Team Expansion'}],
    ['classlist', {name: 'Class List'}],
    ['courses', {name: 'Courses'}],
    ['review', {name: 'Review'}]
])

class SubmissionFlowComponent extends SubmissionBase {
    render() {
        if (!this.checkReportingDate()) {
            return this.renderBasicLoading()
        }
        return (
            <div className="row">
                <div className="col-md-2"><SubmissionNav params={this.props.params} steps={steps} location={this.props.location} /></div>
                <div className="col-md-10">
                    <div className="panel panel-default">
                        <div className="panel-body">
                            {this.props.children}
                        </div>
                    </div>
                </div>
            </div>
        )
    }

    checkReportingDate() {
        if (this.props.params.reportingDate != this.props.reportingDate) {
            this.props.dispatch({
                type: 'submission.setReportingDate',
                payload: this.props.params.reportingDate
            })
            return false
        }
        return true
    }
}

const mapStateToProps = (state) => state.submission.core

const SubmissionFlowRoot = connect(mapStateToProps)(SubmissionFlowComponent)
export default SubmissionFlowRoot

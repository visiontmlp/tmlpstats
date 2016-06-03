import React from 'react'

const { PropTypes } = React

/**
 * ModeSelectButtons renders side-by-side buttons used for mode selector, with appropriate active state.
 *
 * Typical props:
 *   - items: array of objects describing the item. Typically, the item must have props 'key' and 'label'
 *   - current: The key value of the currently selected item. string or number.
 *   - onClick: a callback which will be called with the selected key on item change.
 *
 * Optional props:
 *   - ariaGroupDesc: Used to provide an ARIA label to the button group which describes what it does.
 */
export class ModeSelectButtons extends React.Component {
    static defaultProps = {
        keyProp: 'key',
        getLabel: (v) => v.label
    }
    static propTypes = {
        items: PropTypes.arrayOf(PropTypes.object).isRequired,
        current: PropTypes.oneOfType([
            PropTypes.string,
            PropTypes.number
        ]),
        ariaGroupDesc: PropTypes.string,
        onClick: PropTypes.func
    }

    render() {
        var buttons = []
        this.props.items.forEach((item) => {
            var key = item[this.props.keyProp]
            var classes = 'btn btn-default'
            if (key == this.props.current) {
                classes += ' active'
            }
            var cb = () => this.props.onClick(key, item)
            buttons.push(
                <button key={key} type="button" className={classes} onClick={cb}>
                    {this.props.getLabel(item)}
                </button>
            )
        })

        return (
            <div className="btn-group" role="group" aria-label={this.props.ariaGroupDesc}>
                {buttons}
            </div>
        )
    }
}

/**
 * LoadStateFlip is a really simple experimental component for choosing what's shown based on load state.
 *
 * This should
 */
export class LoadStateFlip extends React.Component {
    render() {
        var loadState = this.props.loadState
        if (loadState.state == 'loading') {
            return <div><span className="glyphicon glyphicon-send"></span>TODO spinner here...</div>
        } else if (loadState.state == 'failed') {
            var error = 'FAILED '
            if (loadState.error) {
                if (loadState.error.message) {
                    error += loadState.error.message
                } else {
                    error += loadState.error
                }
            }
            return <div className="bg-danger">{error}</div>
        } else {
            return <div>{this.props.children}</div>
        }
    }
}
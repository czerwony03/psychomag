import React from 'react';
import PropTypes from 'prop-types';
import Styles from './styles';
import { withStyles } from '@material-ui/core/styles';

class Marker extends React.PureComponent {

    static propTypes = {
        r: PropTypes.number.isRequired,
        cx: PropTypes.number.isRequired,
        cy: PropTypes.number.isRequired,
        fontSize: PropTypes.number.isRequired,
        theme: PropTypes.object,
        text: PropTypes.string.isRequired,
        onClick: PropTypes.func,
        classes: PropTypes.any.isRequired,
        lx: PropTypes.any,
        ly: PropTypes.any,
    };

    render() {
        let x = (this.props.cx - this.props.r),
            y = (this.props.cy - this.props.r),
            width = this.props.r * 2,
            height = this.props.r * 2,
            stroke = this.props.theme.stroke,
            fill = this.props.theme.fill;
        return (
            <g transform={"translate(" + this.props.cx + "," + this.props.cy + ")"} onClick={this.props.onClick} className={this.props.classes.marker}>
                {this.props.theme.fill === '#0D0' && this.props.lx && this.props.ly && <line x1="0" y1="0" x2={this.props.lx} y2={this.props.ly} strokeWidth="1" stroke="black"/>}
                <circle cx={0} cy={0} r={this.props.r} stroke={stroke} fill={fill}/>
                <text x="0" y="0" textAnchor="middle" dy=".3em" fontSize={this.props.fontSize}>
                    {this.props.text.toUpperCase()}
                </text>
            </g>);
    };
}

export default withStyles(Styles)(Marker)

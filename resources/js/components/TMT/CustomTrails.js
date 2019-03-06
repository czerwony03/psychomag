import React from 'react';
import Trails from '@orcatech/react-neuropsych-trails';
import Marker from './Marker';
import Theme from './Theme';

import TrailsA25V1 from './Trails/A25V1';
import TrailsA25V2 from './Trails/A25V2';
import TrailsA25V3 from './Trails/A25V3';
import TrailsB13ALV1 from './Trails/B13ALV1';
import TrailsB13ALV2 from './Trails/B13ALV2';
import TrailsB13ALV3 from './Trails/B13ALV3';


class CustomTrails extends Trails {

    trail = () => {
        switch(this.props.part) {
            case "A25V1":
                return TrailsA25V1;
            case "A25V2":
                return TrailsA25V2;
            case "A25V3":
                return TrailsA25V3;
            case "B13ALV1":
                return TrailsB13ALV1;
            case "B13ALV2":
                return TrailsB13ALV2;
            case "B13ALV3":
                return TrailsB13ALV3;
            default:
                return TrailsA25V1;
        }
    };

    renderMarkers = (tokens, diameter, scale) => {
        let markers = [];
        for (let i = 0; i < tokens.length; i++) {
            // if correctly selected show as completed
            let theme = this.props.progress > i ?
                Theme.success :
                Theme.error;

            // if next in line to be selected handle with success
            // else handle with error
            let handler = this.props.progress === i ?
                (e) => this.handleSuccess(e, i) :
                (e) => this.handleError(e, i);

            // if finished, don't listen anymore
            if (this.props.progress >= tokens.length) {
                handler = undefined;
            }

            // add the marker keyed to the token
            const cx=Math.floor(tokens[i].x * scale);
            const cy=Math.floor(tokens[i].y * scale);
            let lx=0;
            let ly=0;
            if(i) {
                lx = Math.floor(tokens[i-1].x * scale)-cx;
                ly = Math.floor(tokens[i-1].y * scale)-cy;
            } else {
                lx = 9999;
                ly = 9999;
            }
            markers.push(
                <Marker
                    cx={cx}
                    cy={cy}
                    lx={lx}
                    ly={ly}
                    fontSize={Math.floor(diameter/2 * scale)}
                    key={"trails-marker-" + tokens[i].text}
                    onClick={handler}
                    r={Math.floor(diameter/2 * scale)}
                    text={tokens[i].text}
                    theme={theme}
                />);
        }
        return markers;
    };
}

export default CustomTrails;

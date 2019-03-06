import Trails from '@orcatech/react-neuropsych-trails';

import TrailsA12V1 from './Trails/A12V1';
import TrailsA12V2 from './Trails/A12V2';
import TrailsA12V3 from './Trails/A12V3';


class CustomTrails extends Trails {

    trail = () => {
        switch(this.props.part) {
            case "A12V1":
                return TrailsA12V1;
            case "A12V2":
                return TrailsA12V2;
            case "A12V3":
                return TrailsA12V3;
            default:
                return TrailsA12V1;
        }
    }
}

export default CustomTrails;

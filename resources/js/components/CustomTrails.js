import Trails from '@orcatech/react-neuropsych-trails';

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
    }
}

export default CustomTrails;

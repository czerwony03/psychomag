import PropTypes from 'prop-types';
import React from 'react';
import ReactDOM from 'react-dom';
import Modal from 'react-modal';
import CustomTrails from './TMT/CustomTrails';
import InstructionA from '../../img/TMT_A.png';
import InstructionB from '../../img/TMT_B.png';

const customStyles = {
    content : {
        top                   : '50%',
        left                  : '50%',
        right                 : 'auto',
        bottom                : 'auto',
        marginRight           : '-50%',
        transform             : 'translate(-50%, -50%)'
    }
};
const tmttest = document.getElementById("tmttest");
if(tmttest) {
    Modal.setAppElement('#tmttest');
}

class TMT extends React.Component {
    static propTypes = {
        part: PropTypes.string.isRequired,
        prepare: PropTypes.string.isRequired,
        ver: PropTypes.string.isRequired
    };

    state = {
        progress: 0,
        modalIsOpen: false
    };

    constructor(props) {
        super(props);
        this.data = {
            start: undefined,
            stop: undefined,
            events: []
        };

        this.openModal = this.openModal.bind(this);
        this.afterOpenModal = this.afterOpenModal.bind(this);
        this.closeModal = this.closeModal.bind(this);
    }

    openModal() {
        this.setState({modalIsOpen: true});
    }

    afterOpenModal() {
        this.subtitle.style.color = '#f00';
    }

    closeModal() {
        this.setState({modalIsOpen: false});

        const time = (this.data.stop - this.data.start);
        const times = (time/1000);
        const sum = this.data.events.length;
        let err = 0;
        let ok = 0;
        const events = this.data.events;
        events.forEach(data => {
            if(data.type === "OK") {
                ok++;
            } else if(data.type === "Err") {
                err++;
            }
        });
        this.post(window.location.origin + '/test/save',{
            'test_code': 'tmt_' + this.props.ver.toLowerCase() + (this.props.prepare ? '_prepare' : ''),
            'test_result': JSON.stringify({
                'errors': err,
                'ok': ok,
                'time': time,
                'data': events
            })
        });
    }

    componentWillMount() {
        this.data.start = new Date().getTime();
    }

    update = (type, date, correctToken, selectedToken) => {
        this.data.events.push({
            stamp: date.getTime(),
            type: type,
            correctToken: correctToken,
            selectedToken: selectedToken
        });
        console.log(this.data.events[this.data.events.length-1]);
    };

    handleMiss = (date, correctToken, x, y) => {
        this.update("Miss", date, correctToken, { text: "", x: x, y: y });
    };

    handleSuccess = (date, token) => {
        this.update("OK", date, token, token);
        this.setState(prev => ({ progress: ++prev.progress }));
    };

    handleError = (date, correctToken, selectedToken) => {
        this.update("Err", date, correctToken, selectedToken);
    };

    handleCompleted = (date) => {
        this.data.stop = date.getTime();
        console.log("Wyniki testu:");
        console.log(this.data);
        this.openModal();
    };

    post = (path, params, method) => {
        method = method || "post";

        params._token=document.head.querySelector('meta[name="csrf-token"]').content;

        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);

        for(var key in params) {
            if(params.hasOwnProperty(key)) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);

                form.appendChild(hiddenField);
            }
        }

        document.body.appendChild(form);
        form.submit();
    };

    renderResult = () => {
        const time = (this.data.stop - this.data.start);
        const times = (time/1000);
        const sum = this.data.events.length;
        let err = 0;
        let ok = 0;
        const events = this.data.events;
        events.forEach(data => {
            if(data.type === "OK") {
                ok++;
            } else if(data.type === "Err") {
                err++;
            }
        });

        return <div>
            <ul>
                <p>Czas: {time} ms ({times} s)</p>
                <p>Ilość błędów: {err}/{ok}</p>
            </ul>
        </div>;
    };

    render() {
        return <div>
            <CustomTrails
                part={this.props.part}
                progress={this.state.progress}
                feedback={true}
                errorText="X"
                errorDuration={500}
                completedText={"Test zakończony. Generuje wynik..."}
                onSuccess={this.handleSuccess}
                onError={this.handleError}
                onMiss={this.handleMiss}
                onCompleted={this.handleCompleted}
            />
            <Modal
                isOpen={this.state.modalIsOpen}
                onAfterOpen={this.afterOpenModal}
                onRequestClose={this.closeModal}
                style={customStyles}
                contentLabel={"Wyniki TMT A" + this.props.ver}
            >
                <h2 ref={subtitle => this.subtitle = subtitle}>Wyniki testu TMT {this.props.ver}</h2>
                <div>
                    {
                        this.state.modalIsOpen && this.renderResult()
                    }
                </div>
                <button className='btn btn-success' onClick={this.closeModal}>Dalej</button>
            </Modal>
        </div>;
    }
}

class TMTBox extends React.Component {
    static propTypes = {
        prepare: PropTypes.string.isRequired,
        part: PropTypes.string.isRequired,
        ver: PropTypes.string.isRequired
    };
    renderTest() {
        ReactDOM.render(<TMT prepare={this.props.prepare} ver={this.props.ver} part={this.props.part}/>, document.getElementById('tmttest'));
    }
    render() {
        return <div>
            {
                !this.props.prepare &&
                <span>To była tylko rozgrzewka. Teraz pora na prawdziwy test!<br/>
                </span>
            }
            {
                this.props.ver === 'A' && this.props.prepare &&
                <span>Na ekranie zobaczysz punkty oznaczone cyframi od 1 do 25.<br/>
                Twoim zadaniem będzie jak najszybsze połączenie w kolejności numerycznej tych punktów.<br/>
                <img src={InstructionA}/><br/>
                </span>
            }
            {
                this.props.ver === 'B' && this.props.prepare &&
                <span>Na ekranie zobaczysz punkty oznaczone cyframi od 1 do 25 i litery od A do L.<br/>
                Twoim zadaniem będzie jak najszybsze połączenie linią ciągłą naprzemiennie cyfry z kolejnymi literami alfabetu według wzoru:<br/>
                1-A-2-B-3-C-4-D itd.<br/>
                <img src={InstructionB}/><br/>
                </span>
            }<br/>
            <button className='btn btn-success' onClick={this.renderTest.bind(this)}>START</button>
        </div>;
    }
}

export default (TMTBox);

if(tmttest) {
    let trails = [];
    if(tmttest.dataset.ver === 'A' && tmttest.dataset.prepare) {
        trails = [
            "A_PREPARE",
        ];
    } else if(tmttest.dataset.ver === 'B' && tmttest.dataset.prepare) {
        trails = [
            "B_PREPARE",
        ];
    } else if(tmttest.dataset.ver === 'A') {
        trails = [
            "A25V1",
            "A25V2",
            "A25V3",
        ];
    } else if(tmttest.dataset.ver === 'B') {
        trails = [
            "B13ALV1",
            "B13ALV2",
            "B13ALV3",
        ];
    }
    ReactDOM.render(<TMTBox prepare={tmttest.dataset.prepare} ver={tmttest.dataset.ver} part={trails[Math.floor(Math.random() * trails.length)]}/>, document.getElementById('tmttest'));
}

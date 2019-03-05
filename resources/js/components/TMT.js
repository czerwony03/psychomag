import PropTypes from 'prop-types';
import React from 'react';
import ReactDOM from 'react-dom';
import Modal from 'react-modal';
import CustomTrails from './CustomTrails';

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

const trails = [
    "A12V1",
    "A12V2",
    "A12V3",
];

Modal.setAppElement('#tmttest');

class TMT extends React.Component {
    static propTypes = {
        part: PropTypes.string.isRequired,
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
                contentLabel="Wyniki TMT A"
            >
                <h2 ref={subtitle => this.subtitle = subtitle}>Wyniki testu TMT A</h2>
                <div>
                    {
                        this.state.modalIsOpen && this.renderResult()
                    }
                </div>
                <button className='btn btn-danger' onClick={this.closeModal}>Zamknij</button>
            </Modal>
        </div>;
    }
}

export default (TMT);

ReactDOM.render(<TMT part={trails[Math.floor(Math.random()*trails.length)]}/>, document.getElementById('tmttest'));

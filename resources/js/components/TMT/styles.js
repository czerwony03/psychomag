var styles = {
    marker: {
        '&:hover': {
            cursor: 'pointer',
        },
        '& text': {
            userSelect: "none",
        }
    },
    popUp: {
        display: "inline-block",
        fontSize: "1em",
        left: "0%",
        position: "absolute",
        textAlign: "center",
        top: "50%",
        width: "100%",
    },
    popUpRetry: {
        display: "inline-block",
        fontSize: "1em",
        left: "0%",
        position: "absolute",
        textAlign: "center",
        top: "35%",
        width: "100%",
    },
    'popUpContent': {
        maxWidth: "100%",
        display: "inline-block",
        verticalAlign: "middle",
        margin: "0px auto",
        wordWrap: "normal",
        textAlign: "center",
        border: "1px solid #999",
        borderRadius: "5px",
        padding: "10px 15px",
    }
};

export default styles;

import React, { useState } from 'react';
import './App.css';
import axios from 'axios';

function App() {
  const [numPeople, setNumPeople] = useState('');
  const [result, setResult] = useState('');
  const [error, setError] = useState('');

  const handleInputChange = (event) => {
    setNumPeople(event.target.value);
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    setError('');
    setResult('');

    // Validate input
    const people = parseInt(numPeople, 10);
    if (isNaN(people) || people <= 0 || people > 52) {
      setError('Input value does not exist or value is invalid');
      return;
    }

    try {
      const response = await axios.get(`http://localhost/card-distribution/index.php?numPeople=${people}`);
      setResult(response.data.result);
    } catch (err) {
      setError('Error while distributing cards. Please try again.');
    }
  };

  return (
    <div className="App">
      <h1>Card Shuffling & Distribution</h1>
      <form onSubmit={handleSubmit}>
        <div>
          <label>How many people are playing ?</label>
          <br/><br/>
          <input
            type="number"
            value={numPeople}
            onChange={handleInputChange}
            min="1"
            max="52"
            required
          />
        </div>
        <br/>
        <button type="submit">Distribute Cards</button>
      </form>

      {error && <p style={{ color: 'red' }}>{error}</p>}
      {result && (
        <div>
          <h2>Distributed Cards:</h2>
          <pre>{result}</pre>
        </div>
      )}
    </div>
  );
}

export default App;
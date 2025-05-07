import React from 'react';
import { View, StyleSheet, ScrollView } from 'react-native';
import FeedbackForm from './components/Feedback/FeedbackForm';

export default function Feedback() {
  return (
    <ScrollView style={styles.container}>
      <FeedbackForm />
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
});
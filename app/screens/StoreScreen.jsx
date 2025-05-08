import React, { useState, useEffect } from 'react';
import {
  View,
  ScrollView,
  StyleSheet,
  Text,
  TouchableOpacity,
} from 'react-native';
import AIProductRecommendations from '../components/store/AIProductRecommendations';
import AIAssistant from '../components/AIAssistant';
import ProductCard from '../components/store/ProductCard'
import { MendableAI } from '../utils/mendableAI';

const StoreScreen = () => {
  const [showAIAssistant, setShowAIAssistant] = useState(false);
  const [userPreferences, setUserPreferences] = useState(null);

  useEffect(() => {
    analyzeUserPreferences();
  }, []);

  const analyzeUserPreferences = async () => {
    const preferences = await MendableAI.analyzeUserPreferences({
      recentViews: ['skincare', 'natural'],
      purchases: ['moisturizer'],
    });
    setUserPreferences(preferences);
  };

  return (
    <View style={styles.container}>
      <ScrollView style={styles.scrollView}>
        <View style={styles.header}>
          <Text style={styles.title}>AI-Powered Beauty Store</Text>
          <TouchableOpacity
            style={styles.assistantButton}
            onPress={() => setShowAIAssistant(!showAIAssistant)}
          >
            <Text style={styles.assistantButtonText}>
              {showAIAssistant ? 'Hide AI Assistant' : 'Show AI Assistant'}
            </Text>
          </TouchableOpacity>
        </View>

        {showAIAssistant && (
          <View style={styles.assistantContainer}>
            <AIAssistant />
          </View>
        )}

        <View style={styles.recommendationsSection}>
          <AIProductRecommendations userPreferences={userPreferences} />
        </View>

        <View style={styles.featuredSection}>
          <Text style={styles.sectionTitle}>Featured Products</Text>
          <ProductCard />
        </View>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f6fa',
  },
  scrollView: {
    flex: 1,
  },
  header: {
    padding: 15,
    backgroundColor: '#fff',
    borderBottomWidth: 1,
    borderBottomColor: '#e1e8ed',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#2c3e50',
    marginBottom: 10,
  },
  assistantButton: {
    backgroundColor: '#3498db',
    padding: 10,
    borderRadius: 8,
    alignItems: 'center',
  },
  assistantButtonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: '600',
  },
  assistantContainer: {
    height: 400,
    margin: 15,
    backgroundColor: '#fff',
    borderRadius: 12,
    overflow: 'hidden',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 5,
  },
  recommendationsSection: {
    marginVertical: 15,
  },
  featuredSection: {
    padding: 15,
  },
  sectionTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#2c3e50',
    marginBottom: 15,
  },
});

export default StoreScreen;